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

  const ctx = document.getElementById(canvasId).getContext('2d');
  createBarChart(ctx, labels, values, title);
}

loadAndRenderChart('/proj/api/energy-share-total', 'chart-total', 'Förnybar energi - total (%)', 'total');
loadAndRenderChart('/proj/api/energy-share-total', 'chart-industry', 'Förnybar energi - värme, kyla, industry..mm (%)', 'value');
loadAndRenderChart('/proj/api/energy-share-el', 'chart-el', 'Förnybar energi - el (%)', 'el');
loadAndRenderChart('/proj/api/energy-share-el', 'chart-transport', 'Förnybar energi - transporter (%)', 'transport');
loadAndRenderChart('/proj/api/energy-intensity', 'myChart', 'Intensitet per BNP (%)', 'value');
