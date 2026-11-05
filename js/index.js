
(() => {
  const rows = document.getElementById('transactionRows');
  const search = document.getElementById('searchInput');
  const typeFilter = document.getElementById('typeFilter');
  const sortFilter = document.getElementById('sortFilter');
  const emptyState = document.getElementById('emptyState');
  const rowCount = document.getElementById('rowCount');
  const form = document.getElementById('transactionForm');
  const modalEl = document.getElementById('transactionModal');
  const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
  const toast = bootstrap.Toast.getOrCreateInstance(document.getElementById('appToast'));
  const money = n => '৳ ' + Number(n).toLocaleString('en-BD', {minimumFractionDigits:2, maximumFractionDigits:2});
  const today = new Date();
  document.getElementById('transactionDate').value = today.toISOString().slice(0,10);

  function notify(message) {
    document.getElementById('toastMessage').textContent = message;
    toast.show();
  }
  function filterRows() {
    const q = search.value.trim().toLowerCase();
    const type = typeFilter.value;
    const all = [...rows.querySelectorAll('tr')];
    all.sort((a,b) => {
      const mode = sortFilter.value;
      if (mode === 'newest') return b.dataset.date.localeCompare(a.dataset.date);
      if (mode === 'oldest') return a.dataset.date.localeCompare(b.dataset.date);
      if (mode === 'high') return Number(b.dataset.amount)-Number(a.dataset.amount);
      if (mode === 'low') return Number(a.dataset.amount)-Number(b.dataset.amount);
      return 0;
    });
    let visible = 0;
    all.forEach(row => {
      const match = (!q || (row.dataset.search + ' ' + row.textContent).toLowerCase().includes(q)) && (type === 'all' || row.dataset.type === type);
      row.hidden = !match;
      if (match) visible++;
      rows.appendChild(row);
    });
    emptyState.style.display = visible ? 'none' : 'block';
    document.getElementById('transactionTable').style.display = visible ? 'table' : 'none';
    rowCount.textContent = `Showing ${visible} transaction${visible === 1 ? '' : 's'}`;
  }
  [search,typeFilter,sortFilter].forEach(el => el.addEventListener(el === search ? 'input' : 'change', filterRows));

  rows.addEventListener('click', e => {
    const button = e.target.closest('button');
    if (!button) return;
    const row = button.closest('tr');
    if (button.classList.contains('delete-btn')) {
      if (confirm('Delete this transaction from the demo?')) {
        row.remove(); filterRows(); notify('Transaction removed from this demo.');
      }
    } else if (button.classList.contains('edit-btn')) {
      notify('Edit is a UI placeholder. Connect it to your PHP update handler.');
    }
  });


  filterRows();
})();
