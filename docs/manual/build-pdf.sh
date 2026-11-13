#!/usr/bin/env bash
# Rigenera manuale-uso.pdf da manuale-uso.md (richiede pandoc e Playwright con Chromium installato).
# PLAYWRIGHT_MODULE=/percorso/playwright per usare un Playwright diverso da quello della repo.
set -euo pipefail
cd "$(dirname "$0")"
pandoc manuale-uso.md -f markdown-implicit_figures -s --metadata title="TechPlanner — Manuale d'uso" --metadata pagetitle="TechPlanner — Manuale d'uso" \
  -V title= --css manual.css -o .manuale-uso.html
node -e "
const { chromium } = require(process.env.PLAYWRIGHT_MODULE || 'playwright');
(async () => {
  const b = await chromium.launch(); const p = await b.newPage();
  await p.goto('file://' + process.cwd() + '/.manuale-uso.html', { waitUntil: 'load' });
  await p.pdf({ path: 'manuale-uso.pdf', format: 'A4', printBackground: true, displayHeaderFooter: true,
    headerTemplate: '<span></span>',
    footerTemplate: '<div style=\"font-size:8px;width:100%;text-align:center;color:#888\">TechPlanner — Manuale d\'uso · pagina <span class=pageNumber></span> di <span class=totalPages></span></div>',
    margin: { top: '18mm', bottom: '20mm', left: '16mm', right: '16mm' } });
  await b.close();
})();"
rm -f .manuale-uso.html
