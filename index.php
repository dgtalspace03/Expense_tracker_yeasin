<?php include("pdo_connect.php")?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MoneyTrack — Expense Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container app-shell py-1">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2 mb-0" href="#">
                <span class="brand-mark"><i class="bi bi-wallet2"></i></span><span>Money<span class="text-primary">Track</span></span>
            </a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="d-none d-sm-inline small muted">Welcome back, <strong class="text-dark">Alex</strong></span>
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle" data-bs-toggle="dropdown" aria-label="Account menu"><i class="bi bi-person"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Log out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <main class="container app-shell py-4 py-lg-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <div class="small muted mb-1">PERSONAL FINANCE</div>
                <h1 class="page-title h2 fw-bold mb-1">Dashboard</h1>
                <p class="muted mb-0">A clear overview of your money.</p>
            </div>
            <button class="btn btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#transactionModal" id="openAdd"><i class="bi bi-plus-lg me-2"></i>Add transaction</button>
        </div>

        <section class="row g-3 mb-4" aria-label="Account summary">
            <div class="col-12 col-md-4">
                <div class="summary-card">
                    <div class="d-flex justify-content-between align-items-start mb-3"><span class="summary-label">Current balance</span><span class="summary-icon" style="background:#edf1ff;color:#3157d5"><i class="bi bi-wallet2"></i></span></div>
                    <div class="summary-value" id="balanceValue">৳ 24,850.00</div>
                    <div class="small muted mt-1">Your available balance</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="summary-card">
                    <div class="d-flex justify-content-between align-items-start mb-3"><span class="summary-label">Total income</span><span class="summary-icon" style="background:#e8f7ef;color:#16834a"><i class="bi bi-arrow-down-left"></i></span></div>
                    <div class="summary-value text-success" id="incomeValue">৳ 35,000.00</div>
                    <div class="small muted mt-1">This month</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="summary-card">
                    <div class="d-flex justify-content-between align-items-start mb-3"><span class="summary-label">Total expenses</span><span class="summary-icon" style="background:#fff0ed;color:#c34c3a"><i class="bi bi-arrow-up-right"></i></span></div>
                    <div class="summary-value" id="expenseValue">৳ 10,150.00</div>
                    <div class="small muted mt-1">This month</div>
                </div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <div>
                    <h2 class="h5 fw-bold mb-1">Recent transactions</h2>
                    <p class="small muted mb-0">View and manage your income and expenses.</p>
                </div>
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search muted"></i></span>
                        <input type="search" class="form-control border-start-0 ps-0" id="searchInput" placeholder="Search transactions" aria-label="Search transactions">
                    </div>
                    <select class="form-select" id="typeFilter" aria-label="Filter transaction type" style="min-width:140px">
                        <option value="all">All types</option>
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                    <select class="form-select" id="sortFilter" aria-label="Sort transactions" style="min-width:150px">
                        <option value="newest">Newest first</option>
                        <option value="oldest">Oldest first</option>
                        <option value="high">Amount: high–low</option>
                        <option value="low">Amount: low–high</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table mb-0" id="transactionTable">
                    <thead>
                        <tr>
                            <th class="ps-4">Transaction</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th class="text-end">Amount</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="transactionRows">
                        <tr data-type="expense" data-amount="850" data-date="2026-11-05" data-search="grocery shopping food">
                            <td class="ps-4">
                                <div class="d-flex align-items-center"><span class="category-icon" style="background:#fff5e8;color:#c17a16"><i class="bi bi-cart3"></i></span>
                                    <div>
                                        <div class="fw-semibold">Grocery shopping</div>
                                        <div class="small muted">Weekly groceries</div>
                                    </div>
                                </div>
                            </td>
                            <td>Food</td>
                            <td class="small muted">Nov 05, 2026</td>
                            <td><span class="badge badge-expense rounded-pill px-2 py-2">Expense</span></td>
                            <td class="text-end fw-semibold text-danger">− ৳ 850.00</td>
                            <td class="text-end pe-4"><button class="btn btn-sm btn-light text-secondary edit-btn" title="Edit"><i class="bi bi-pencil"></i></button> <button class="btn btn-sm btn-light text-danger delete-btn" title="Delete"><i class="bi bi-trash3"></i></button></td>
                        </tr>
                        <tr data-type="income" data-amount="30000" data-date="2026-11-03" data-search="monthly salary work">
                            <td class="ps-4">
                                <div class="d-flex align-items-center"><span class="category-icon" style="background:#eaf2ff;color:#3564c8"><i class="bi bi-briefcase"></i></span>
                                    <div>
                                        <div class="fw-semibold">Monthly salary</div>
                                        <div class="small muted">November salary</div>
                                    </div>
                                </div>
                            </td>
                            <td>Salary</td>
                            <td class="small muted">Nov 03, 2026</td>
                            <td><span class="badge badge-income rounded-pill px-2 py-2">Income</span></td>
                            <td class="text-end fw-semibold text-success">+ ৳ 30,000.00</td>
                            <td class="text-end pe-4"><button class="btn btn-sm btn-light text-secondary edit-btn" title="Edit"><i class="bi bi-pencil"></i></button> <button class="btn btn-sm btn-light text-danger delete-btn" title="Delete"><i class="bi bi-trash3"></i></button></td>
                        </tr>
                        <tr data-type="expense" data-amount="1200" data-date="2026-11-02" data-search="internet bill utilities">
                            <td class="ps-4">
                                <div class="d-flex align-items-center"><span class="category-icon" style="background:#f1edff;color:#7652c8"><i class="bi bi-wifi"></i></span>
                                    <div>
                                        <div class="fw-semibold">Internet bill</div>
                                        <div class="small muted">Home internet</div>
                                    </div>
                                </div>
                            </td>
                            <td>Utilities</td>
                            <td class="small muted">Nov 02, 2026</td>
                            <td><span class="badge badge-expense rounded-pill px-2 py-2">Expense</span></td>
                            <td class="text-end fw-semibold text-danger">− ৳ 1,200.00</td>
                            <td class="text-end pe-4"><button class="btn btn-sm btn-light text-secondary edit-btn" title="Edit"><i class="bi bi-pencil"></i></button> <button class="btn btn-sm btn-light text-danger delete-btn" title="Delete"><i class="bi bi-trash3"></i></button></td>
                        </tr>
                        <tr data-type="expense" data-amount="500" data-date="2026-11-01" data-search="coffee snacks food">
                            <td class="ps-4">
                                <div class="d-flex align-items-center"><span class="category-icon" style="background:#fff0f4;color:#c34e78"><i class="bi bi-cup-hot"></i></span>
                                    <div>
                                        <div class="fw-semibold">Coffee and snacks</div>
                                        <div class="small muted">Afternoon break</div>
                                    </div>
                                </div>
                            </td>
                            <td>Food</td>
                            <td class="small muted">Nov 01, 2026</td>
                            <td><span class="badge badge-expense rounded-pill px-2 py-2">Expense</span></td>
                            <td class="text-end fw-semibold text-danger">− ৳ 500.00</td>
                            <td class="text-end pe-4"><button class="btn btn-sm btn-light text-secondary edit-btn" title="Edit"><i class="bi bi-pencil"></i></button> <button class="btn btn-sm btn-light text-danger delete-btn" title="Delete"><i class="bi bi-trash3"></i></button></td>
                        </tr>
                        <tr data-type="income" data-amount="5000" data-date="2026-10-29" data-search="freelance project work">
                            <td class="ps-4">
                                <div class="d-flex align-items-center"><span class="category-icon" style="background:#eaf2ff;color:#3564c8"><i class="bi bi-laptop"></i></span>
                                    <div>
                                        <div class="fw-semibold">Freelance project</div>
                                        <div class="small muted">Website work</div>
                                    </div>
                                </div>
                            </td>
                            <td>Freelance</td>
                            <td class="small muted">Oct 29, 2026</td>
                            <td><span class="badge badge-income rounded-pill px-2 py-2">Income</span></td>
                            <td class="text-end fw-semibold text-success">+ ৳ 5,000.00</td>
                            <td class="text-end pe-4"><button class="btn btn-sm btn-light text-secondary edit-btn" title="Edit"><i class="bi bi-pencil"></i></button> <button class="btn btn-sm btn-light text-danger delete-btn" title="Delete"><i class="bi bi-trash3"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="empty-state" id="emptyState"><i class="bi bi-search fs-2 d-block mb-2"></i>
                <div class="fw-semibold text-dark">No transactions found</div>
                <div class="small">Try changing your search or filter.</div>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 p-3 px-4 border-top" style="border-color:var(--line)!important">
                <span class="small muted" id="rowCount">Showing 5 transactions</span>
                <div class="d-flex gap-2"><button class="btn btn-sm btn-outline-secondary" disabled>Previous</button><button class="btn btn-sm btn-primary">1</button><button class="btn btn-sm btn-outline-secondary" disabled>Next</button></div>
            </div>
        </section>
        <div class="small muted text-center mt-4">MoneyTrack · Simple personal finance management</div>
    </main>

   <?php include("Modal/add_transaction_modal.php") ?>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="appToast" class="toast border-0 shadow" role="status" aria-live="polite" aria-atomic="true">
            <div class="toast-body d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span id="toastMessage">Done</span><button type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/index.js"></script>
</body>

</html>