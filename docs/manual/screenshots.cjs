// Screenshot del manuale d'uso, con riquadri rossi numerati sugli elementi da usare.
const { chromium } = require(process.env.PLAYWRIGHT_MODULE || 'playwright');
// Il tenant si riconosce dal nome host: il browser risolve manuale.local sul server locale.
const base = process.env.MANUAL_BASE || 'http://manuale.local:8000';
const out = process.argv[2];
const only = process.argv[3] ? process.argv[3].split(',') : null;
const PASS = process.env.MANUAL_DEMO_PASSWORD; if (!PASS) throw new Error('Imposta MANUAL_DEMO_PASSWORD');
const IDS = { bianchi: 11, device: 14 };

async function newPage(browser) {
  const ctx = await browser.newContext({ viewport: { width: 1440, height: 900 }, deviceScaleFactor: 2, locale: 'it-IT', timezoneId: 'Europe/Rome' });
  return ctx.newPage();
}
const contexts = {};
// Una sola login per utente (il pannello limita i tentativi al minuto): le scene riusano il contesto.
async function session(browser, panel, email) {
  if (!contexts[email]) {
    const ctx = await browser.newContext({ viewport: { width: 1440, height: 900 }, deviceScaleFactor: 2, locale: 'it-IT', timezoneId: 'Europe/Rome' });
    const pg = await ctx.newPage();
    await login(pg, panel, email);
    await pg.close();
    contexts[email] = ctx;
  }
  return contexts[email].newPage();
}
async function login(page, panel, email) {
  await page.goto(`${base}/${panel}/login`, { waitUntil: 'networkidle' });
  await page.locator('input[type=email]').fill(email);
  await page.locator('input[type=password]').first().fill(PASS);
  await page.getByRole('button', { name: 'Accedi' }).click();
  await page.waitForURL((u) => !u.pathname.endsWith('/login'), { timeout: 60000 });
  await page.waitForLoadState('networkidle');
}
async function go(page, path) {
  await page.goto(`${base}/${path}`, { waitUntil: 'networkidle' });
  await page.waitForTimeout(600);
}
// Disegna un riquadro rosso con numero su ogni locator (coordinate di documento).
async function mark(page, items) {
  for (const [i, loc] of items.entries()) {
    const box = await loc.boundingBox();
    if (!box) { console.log('  ! riquadro non trovato', i + 1); continue; }
    await page.evaluate(({ box, n }) => {
      const pad = 4;
      const r = document.createElement('div');
      r.className = 'manuale-mark';
      Object.assign(r.style, { position: 'absolute', left: `${box.x + scrollX - pad}px`, top: `${box.y + scrollY - pad}px`,
        width: `${box.width + pad * 2}px`, height: `${box.height + pad * 2}px`, border: '3px solid #e11d48', borderRadius: '8px',
        zIndex: 99999, pointerEvents: 'none', boxShadow: '0 0 0 3px rgba(225,29,72,.18)' });
      const b = document.createElement('div');
      b.textContent = n;
      Object.assign(b.style, { position: 'absolute', left: '-14px', top: '-14px', width: '26px', height: '26px', borderRadius: '50%',
        background: '#e11d48', color: '#fff', font: '700 14px/26px system-ui, sans-serif', textAlign: 'center' });
      r.appendChild(b);
      document.body.appendChild(r);
    }, { box, n: i + 1 });
  }
}
async function unmark(page) { await page.evaluate(() => document.querySelectorAll('.manuale-mark').forEach((e) => e.remove())); }
async function shot(page, name, opts = {}) {
  await page.screenshot({ path: `${out}/${name}.png`, ...opts });
  await unmark(page);
  console.log('ok', name);
}
const row = (page, text) => page.locator('tr', { hasText: text }).first();

const scenes = {
  async '01-accesso'(b) {
    const p = await newPage(b);
    await go(p, 'techplanner/admin/login');
    await p.locator('input[type=email]').fill('segreteria@example.com');
    await p.locator('input[type=password]').first().fill(PASS);
    await mark(p, [p.locator('input[type=email]'), p.locator('input[type=password]').first(), p.getByRole('button', { name: 'Accedi' })]);
    await shot(p, '01-accesso');
  },
  async '02-menu'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin');
    await mark(p, [p.getByRole('button', { name: 'Lavoro quotidiano' }), p.getByRole('button', { name: 'Referenti dei clienti' }), p.getByRole('button', { name: 'Menu utente' })]);
    await shot(p, '02-menu');
  },
  async '03-menu-utente'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin');
    await p.getByRole('button', { name: 'Menu utente' }).click(); await p.waitForTimeout(600);
    await shot(p, '03-menu-utente', { clip: { x: 900, y: 0, width: 540, height: 420 } });
  },
  async '04-dashboard'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin');
    await p.waitForTimeout(800);
    await mark(p, [
      p.locator('.fi-wi-stats-overview-stat').nth(0),
      p.locator('.fi-wi-stats-overview-stat').nth(1),
      p.getByText('Da verificare (scadute', { exact: false }).first(),
      p.getByText('Il giro di oggi', { exact: true }).first(),
    ]);
    await shot(p, '04-dashboard', { fullPage: true });
  },
  async '32-apparecchi-scadenze'(b) {
    const p = await session(b, 'techplanner/admin', 'tecnico@example.com');
    await go(p, 'techplanner/admin/devices?filters[due][value]=30');
    await p.waitForTimeout(800);
    await mark(p, [
      p.locator('.fi-ta-filters').getByText('Scadenza verifica', { exact: true }).locator('..').locator('..'),
      p.locator('th', { hasText: 'Prossima verifica' }).first(),
    ]);
    await shot(p, '32-apparecchi-scadenze');
  },
  async '19-cliente-piva'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin/clients/create');
    await p.locator('input[id$="company_name"]').fill('Studio Prova');
    await p.locator('input[id$="vat_number"]').fill('12345678901');
    await p.getByRole('button', { name: /^Crea$|^Salva$/ }).first().click();
    await p.waitForTimeout(1500);
    const field = p.locator('input[id$="vat_number"]').locator('xpath=ancestor::*[contains(@class,"fi-fo-field")][1]');
    await field.scrollIntoViewIfNeeded(); await p.waitForTimeout(300);
    await mark(p, [field]);
    const box = await field.boundingBox();
    await shot(p, '19-cliente-piva', { clip: { x: 300, y: Math.max(0, box.y - 160), width: 1140, height: 340 } });
  },
  async '56-cestino'(b) {
    const p = await session(b, 'techplanner/admin', 'admin@example.com');
    await go(p, 'techplanner/admin/clients?filters[trashed][value]=0');
    await p.waitForTimeout(800);
    await mark(p, [
      p.locator('.fi-ta-filters').getByText('Record eliminati', { exact: true }).locator('..').locator('..'),
      row(p, 'Studio Chiuso per Errore').getByRole('button', { name: 'Ripristina' }).first(),
    ]);
    await shot(p, '56-cestino');
  },
  async '24-richieste-sito'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin/contact-messages');
    await p.waitForTimeout(600);
    await mark(p, [
      p.locator('.fi-sidebar').getByText('Richieste dal sito', { exact: true }).first(),
      p.locator('.fi-ta-row').first(),
    ]);
    await shot(p, '24-richieste-sito');
  },
  async '10-clienti-elenco'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin/clients');
    await mark(p, [
      p.getByRole('button', { name: 'Nuovo' }).first().or(p.getByRole('link', { name: 'Nuovo' }).first()).first(),
      p.getByPlaceholder('Cerca'),
      p.getByText('Filtri', { exact: true }).locator('..').locator('..'),
      p.getByRole('button', { name: 'Ordina per distanza' }).first(),
    ]);
    await shot(p, '10-clienti-elenco');
  },
  async '11-cliente-nuovo'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin/clients/create');
    await shot(p, '11-cliente-nuovo', { fullPage: true });
  },
  async '12-cliente-scheda'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, `techplanner/admin/clients/${IDS.bianchi}`);
    const tabs = p.locator('.fi-tabs').last();
    await p.mouse.wheel(0, 3000); await p.waitForTimeout(1500); await p.waitForLoadState('networkidle');
    await p.evaluate(() => scrollTo(0, 0)); await p.waitForTimeout(500);
    await mark(p, [p.getByRole('link', { name: 'Modifica' }).or(p.getByRole('button', { name: 'Modifica' })).first(), tabs]);
    await shot(p, '12-cliente-scheda', { fullPage: true });
  },
  async '13-ordina-distanza'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin/clients');
    await row(p, 'Studio Dentistico Bianchi').getByRole('button', { name: 'Ordina per distanza' }).click();
    await p.waitForLoadState('networkidle'); await p.waitForTimeout(1500);
    await p.evaluate(() => scrollTo(0, 0)); await p.waitForTimeout(400);
    await mark(p, [p.locator('th', { hasText: 'Distanza' }).first()]);
    await shot(p, '13-ordina-distanza');
  },
  async '14-aggiorna-coordinate'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin/clients');
    await p.getByRole('button', { name: 'Aggiorna coordinate' }).first().click(); await p.waitForTimeout(800);
    await shot(p, '14-aggiorna-coordinate');
  },
  async '15-importa-clienti'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin/clients');
    await p.getByRole('button', { name: 'Importa Clienti' }).click(); await p.waitForTimeout(1000);
    await shot(p, '15-importa-clienti');
  },
  async '20-chiamata-nuova'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, `techplanner/admin/clients/${IDS.bianchi}`);
    const tab = p.getByRole('tab', { name: 'Chiamate' });
    await tab.scrollIntoViewIfNeeded(); await tab.click(); await p.waitForTimeout(1500); await p.waitForLoadState('networkidle');
    await tab.evaluate((e) => { e.scrollIntoView({ block: 'start' }); scrollBy(0, -120); }); await p.waitForTimeout(500);
    const area = p.locator('.fi-resource-relation-manager, [wire\\:id]').filter({ hasText: 'Chiamate' }).last();
    await mark(p, [tab, p.getByRole('button', { name: 'Nuovo' }).last()]);
    await shot(p, '20-chiamate-scheda');
    await p.getByRole('button', { name: 'Nuovo' }).last().click(); await p.waitForTimeout(1200);
    const dlg = p.getByRole('dialog').last();
    await dlg.locator('input[type=datetime-local]').first().fill('2026-11-05T10:30').catch(() => {});
    await dlg.getByLabel('Durata (secondi)').fill('180').catch(() => {});
    await dlg.getByLabel('Esito e note').fill('Fissata la visita per giovedì alle 9.').catch(() => {});
    await dlg.getByLabel('Direzione').selectOption({ label: 'Uscita' }).catch(async () => { await dlg.getByLabel('Direzione').selectOption({ index: 2 }).catch(() => {}); });
    await shot(p, '21-chiamata-nuova');
  },
  async '22-appuntamento-nuovo'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin/appointments/create');
    await p.locator('.fi-select-input-btn, [role=combobox], button:has-text("Seleziona un\'opzione")').first().click().catch(() => {});
    await p.waitForTimeout(800);
    await p.keyboard.type('Bianchi'); await p.waitForTimeout(1500);
    await p.getByRole('option', { name: /Bianchi/ }).first().click().catch(() => {});
    await p.locator('input[type=datetime-local]').first().fill('2026-11-12T09:00').catch(() => {});
    await p.locator('textarea').first().fill('Verifica biennale. Referente: dott.ssa Bianchi.').catch(() => {});
    await mark(p, [p.getByRole('button', { name: 'Salva', exact: true })]);
    await shot(p, '22-appuntamento-nuovo');
  },
  async '23-appuntamenti-elenco'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin/appointments');
    await p.locator('th', { hasText: 'Data e ora' }).first().click().catch(() => {}); await p.waitForTimeout(1200);
    await mark(p, [p.locator('th', { hasText: 'Data e ora' }).first()]);
    await shot(p, '23-appuntamenti-elenco');
  },
  async '30-apparecchi-elenco'(b) {
    const p = await session(b, 'techplanner/admin', 'tecnico@example.com');
    await go(p, 'techplanner/admin/devices');
    await mark(p, [p.getByPlaceholder('Cerca'), p.locator('tbody tr').first().locator('a, button').first()]);
    await shot(p, '30-apparecchi-elenco');
  },
  async '31-apparecchio-scheda'(b) {
    const p = await session(b, 'techplanner/admin', 'tecnico@example.com');
    await go(p, `techplanner/admin/devices/${IDS.device}`);
    await p.mouse.wheel(0, 3000); await p.waitForTimeout(2500); await p.waitForLoadState('networkidle');
    await p.mouse.wheel(0, -3000); await p.waitForTimeout(400);
    const nuovo = p.getByRole('button', { name: 'Nuovo' }).last();
    await mark(p, [p.getByText('Verifiche', { exact: true }).first(), nuovo]);
    await shot(p, '31-apparecchio-scheda', { fullPage: true });
    await nuovo.click(); await p.waitForTimeout(1200);
    const dlg = p.getByRole('dialog').last();
    const dates = dlg.locator('input[type=date]');
    await dates.nth(0).fill('2026-11-05').catch(() => {});
    await dates.nth(1).fill('2028-11-05').catch(() => {});
    await dlg.getByLabel('Tipo di verifica').fill('Periodica biennale').catch(() => {});
    await dlg.getByLabel('Esito').fill('Conforme').catch(() => {});
    await dlg.getByLabel('Parametri di esposizione').fill('60 kV, 7 mA, 0,2 s').catch(() => {});
    await shot(p, '32-verifica-nuova');
  },
  async '33-apparecchio-nuovo'(b) {
    const p = await session(b, 'techplanner/admin', 'tecnico@example.com');
    await go(p, 'techplanner/admin/devices/create');
    await shot(p, '33-apparecchio-nuovo', { fullPage: true });
  },
  async '40-direttori'(b) {
    const p = await session(b, 'techplanner/admin', 'segreteria@example.com');
    await go(p, 'techplanner/admin/medical-directors');
    await shot(p, '40-direttori');
  },
  async '50-utenti'(b) {
    const p = await session(b, 'techplanner/admin', 'admin@example.com');
    await go(p, 'user/admin/users');
    await mark(p, [p.getByRole('button', { name: 'Nuovo' }).first().or(p.getByRole('link', { name: 'Nuovo' }).first()).first()]);
    await shot(p, '50-utenti');
    await go(p, 'user/admin/users/create');
    await shot(p, '51-utente-nuovo', { fullPage: true });
  },
  async '52-utente-ruoli'(b) {
    const p = await session(b, 'techplanner/admin', 'admin@example.com');
    await go(p, 'user/admin/users/01a1ad5d-88a7-7192-bed4-7272196c6691/edit');
    const tab = p.getByRole('tab', { name: /Organizzazione/ });
    await tab.scrollIntoViewIfNeeded(); await tab.click(); await p.waitForTimeout(2500); await p.waitForLoadState('networkidle');
    await p.mouse.wheel(0, 1500); await p.waitForTimeout(2000); await p.waitForLoadState('networkidle');
    await tab.evaluate((e) => { e.scrollIntoView({ block: 'start' }); scrollBy(0, -100); }); await p.waitForTimeout(600);
    await mark(p, [tab]);
    await shot(p, '52-utente-ruoli');
  },
  async '53-ruoli'(b) {
    const p = await session(b, 'user/admin', 'admin@example.com');
    await go(p, 'user/admin/roles');
    await shot(p, '53-ruoli');
  },
  async '54-pannello-principale'(b) {
    const p = await session(b, 'user/admin', 'admin@example.com');
    await go(p, 'admin');
    await shot(p, '54-pannello-principale');
  },
  async '60-sito'(b) {
    const p = await newPage(b);
    await go(p, 'it');
    await p.getByRole('button', { name: 'Ho capito' }).click().catch(() => {});
    await p.evaluate(() => scrollTo(0, 0)); await p.waitForTimeout(800);
    await shot(p, '60-sito-home');
    await go(p, 'it/contacts');
    const form = p.locator('form').filter({ has: p.locator('textarea') }).first();
    await form.scrollIntoViewIfNeeded().catch(() => {}); await p.waitForTimeout(600);
    await form.evaluate((e) => { e.scrollIntoView({ block: 'start' }); scrollBy(0, -80); }).catch(() => {});
    await p.waitForTimeout(400);
    await shot(p, '62-sito-contatti');
    await go(p, 'it/auth/register');
    await p.evaluate(() => scrollTo(0, 0)); await p.waitForTimeout(500);
    await shot(p, '61-sito-registrazione');
  },
};

(async () => {
  const browser = await chromium.launch({ args: ['--host-resolver-rules=MAP manuale.local 127.0.0.1'] });
  for (const [name, fn] of Object.entries(scenes)) {
    if (only && !only.some((o) => name.startsWith(o))) continue;
    try { await fn(browser); } catch (e) { console.log('ERRORE', name, e.message.split('\n')[0]); }
  }
  await browser.close();
})();
