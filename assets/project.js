import './styles/project.css';
import { createBarChart } from './js/chartModule.js';

import {
  Chart,
  BarController,
  BarElement,
  CategoryScale,
  LinearScale,
  Title,
  Tooltip,
  Legend,
} from 'chart.js';

Chart.register(BarController, BarElement, CategoryScale, LinearScale, Title, Tooltip, Legend);

async function loadAndRenderChart(apiUrl, canvasId, title, dataKey) {
  const response = await fetch(apiUrl);
  const data = await response.json();

  const labels = data.map(item => item.year);
  const values = data.map(item => item[dataKey]);

  const canvas = document.getElementById(canvasId);

  if (!canvas)
    return;

  const ctx = canvas.getContext('2d');

  createBarChart(ctx, labels, values, title);
}

loadAndRenderChart('/proj/api/energy-share-total', 'chart-total', 'Förnybar energi - total (%)', 'total');
loadAndRenderChart('/proj/api/energy-share-total', 'chart-industry', 'Förnybar energi - värme, kyla, industry..mm (%)', 'value');
loadAndRenderChart('/proj/api/energy-share-el', 'chart-el', 'Förnybar energi - el (%)', 'el');
loadAndRenderChart('/proj/api/energy-share-el', 'chart-transport', 'Förnybar energi - transporter (%)', 'transport');
// Den andra tabellen.
loadAndRenderChart('/proj/api/energy-intensity', 'myChart', 'Intensitet per BNP (%)', 'value');
// Den tredje tabellen
loadAndRenderChart('/proj/api/energy-TWh', 'chart-bio', 'Förnybar energi biobränslen', 'bio');
loadAndRenderChart('/proj/api/energy-TWh', 'chart-hydro', 'Förnybar energi vattenkraft', 'hydro');
loadAndRenderChart('/proj/api/energy-TWh', 'chart-wind', 'Förnybar energi vindkraft', 'wind');
loadAndRenderChart('/proj/api/energy-TWh', 'chart-heat', 'Förnybar energi värmepumpar', 'heat');
loadAndRenderChart('/proj/api/TWh-total', 'chart-TWh-total', 'Förnybar energi totalt', 'TWh-total');
loadAndRenderChart('/proj/api/TWh-target', 'chart-TWh-target', 'Förnybar energi målberäkning', 'target');
loadAndRenderChart('/proj/api/TWh-total', 'chart-TWh-total-use', 'Förnybar energi total energianvändning', 'total-use');

// Metod för att filtrera sökningsresultat i formuläret.
async function fetchEnergyTWh(year, type) {
  const response = await fetch('/proj/api/energy-TWh-filter', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ year, type })
  });

  const data = await response.json();

  const container = document.getElementById('result');
  container.innerHTML = '';
  // Visar resultat-fältet som är dold från början.
  container.classList.remove('hidden');

  data.forEach(item => {
    container.innerHTML += `<p>År: ${item.year}, ${type}: ${item[type]} TWh</p>`;
  });
}

function getForm() {
    // Lyssnar på när formuläret skickas (submit).
  let form = document.getElementById('filter-form');

  if (form) {
    form.addEventListener('submit', (event) => {
      event.preventDefault();

      // Hämtar användarens valda värde från ett select-fält.
      const year = document.getElementById('year-input').value;
      const type = document.getElementById('type-input').value;

      // Anropar fetch-metoden.
      fetchEnergyTWh(year, type);
    });
  }
}

getForm();
