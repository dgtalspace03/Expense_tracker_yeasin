
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

  form.addEventListener('submit', e => {
    e.preventDefault();
    const description = document.getElementById('description').value.trim();
    const amount = Number(document.getElementById('amount').value);
    const type = document.getElementById('transactionType').value;
    const category = document.getElementById('category').value;
    const date = document.getElementById('transactionDate').value;
    if (!description || !Number.isFinite(amount) || amount <= 0 || !date) return;
    const d = new Date(date + 'T00:00:00');
    const dateLabel = d.toLocaleDateString('en-US',{month:'short',day:'2-digit',year:'numeric'});
    const icon = type === 'income' ? 'bi-cash-coin' : 'bi-receipt';
    const color = type === 'income' ? '#16834a' : '#c34c3a';
    const sign = type === 'income' ? '+' : '−';
    const tr = document.createElement('tr');
    tr.dataset.type = type; tr.dataset.amount = String(amount); tr.dataset.date = date;
    tr.dataset.search = `${description} ${category}`.toLowerCase();
    tr.innerHTML = `<td class="ps-4"><div class="d-flex align-items-center"><span class="category-icon" style="background:${type==='income'?'#e8f7ef':'#fff0ed'};color:${color}"><i class="bi ${icon}"></i></span><div><div class="fw-semibold"></div><div class="small muted">Added just now</div></div></div></td><td></td><td class="small muted"></td><td><span class="badge rounded-pill px-2 py-2 ${type==='income'?'badge-income':'badge-expense'}">${type==='income'?'Income':'Expense'}</span></td><td class="text-end fw-semibold ${type==='income'?'text-success':'text-danger'}">${sign} ${money(amount)}</td><td class="text-end pe-4"><button class="btn btn-sm btn-light text-secondary edit-btn" title="Edit"><i class="bi bi-pencil"></i></button> <button class="btn btn-sm btn-light text-danger delete-btn" title="Delete"><i class="bi bi-trash3"></i></button></td>`;
    tr.querySelector('.fw-semibold').textContent = description;
    tr.children[1].textContent = category;
    tr.children[2].textContent = dateLabel;
    rows.prepend(tr);
    form.reset(); document.getElementById('transactionDate').value = today.toISOString().slice(0,10);
    modal.hide(); filterRows(); notify('Transaction added to the demo.');
  });
  filterRows();
})();
