<?php include("pdo_connect.php") ?>
<?php include("utils/helper.php") ?>
<?php include("Classes/UserActions.php") ?>
<?php include("Classes/TransactionAction.php") ?>
<?php
session_start();
$user_action = new UserActions($pdo);
$transaction_action = new TransactionAction($pdo);
if (!$user_action->IsLoggedIn()) {
    header("Location:login.php");
    exit;
}
$session_user = $user_action->GetSessionUser();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['description']) && isset($_POST['amount']) && isset($_POST['type']) && isset($_POST['category']) && isset($_POST['date'])) {
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $type = $_POST['type'];
        $category = $_POST['category'];
        $date = $_POST['date'];
        $res = $transaction_action->AddTransaction($description, $session_user['id'], $amount, $type, $category, $date);
        if ($res["success"]) {
            header("Location:index.php");
            exit();
        } else {
            echo htmlspecialchars($res["msg"]);
        }
    }
}

// Fetch AFTER handling POST so the list is always current
$user_transaction_res = $transaction_action->GetUserTransactionsById($session_user['id']);
if (!$user_transaction_res["success"]) {
    echo htmlspecialchars($user_transaction_res["msg"]);
    exit();
}
$user_transactions = $user_transaction_res["transactions"];

// Summary totals
$total_income = 0;
$total_expense = 0;
$month_income = 0;
$month_expense = 0;
$current_month = date('Y-m');
foreach ($user_transactions as $t) {
    $amt = (float) $t['amount'];
    $is_inc = strtolower($t['type']) === 'income';
    $in_month = substr($t['date'], 0, 7) === $current_month;
    if ($is_inc) {
        $total_income += $amt;
        if ($in_month) $month_income += $amt;
    } else {
        $total_expense += $amt;
        if ($in_month) $month_expense += $amt;
    }
}
$balance = $total_income - $total_expense;
$transaction_count = count($user_transactions);
?>
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
                <span class="brand-mark"><i class="bi bi-wallet2"></i></span><span>Money<span
                        class="text-primary">Track</span></span>
            </a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="d-none d-sm-inline small muted">Welcome back, <strong
                        class="text-dark"><?= htmlspecialchars($session_user['name']) ?></strong></span>
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle" data-bs-toggle="dropdown" aria-label="Account menu"><i
                            class="bi bi-person"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><a class="dropdown-item text-danger" href="logout.php"><i
                                    class="bi bi-box-arrow-right me-2"></i>Log out</a></li>
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
            <button class="btn btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#transactionModal"
                id="openAdd"><i class="bi bi-plus-lg me-2"></i>Add transaction</button>
        </div>

        <section class="row g-3 mb-4" aria-label="Account summary">
            <div class="col-12 col-md-4">
                <div class="summary-card">
                    <div class="d-flex justify-content-between align-items-start mb-3"><span
                            class="summary-label">Current balance</span><span class="summary-icon"
                            style="background:#edf1ff;color:#3157d5"><i class="bi bi-wallet2"></i></span></div>
                    <div class="summary-value" id="balanceValue">৳ <?= number_format($balance, 2) ?></div>
                    <div class="small muted mt-1">Your available balance</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="summary-card">
                    <div class="d-flex justify-content-between align-items-start mb-3"><span class="summary-label">Total
                            income</span><span class="summary-icon" style="background:#e8f7ef;color:#16834a"><i
                                class="bi bi-arrow-down-left"></i></span></div>
                    <div class="summary-value text-success" id="incomeValue">৳ <?= number_format($month_income, 2) ?></div>
                    <div class="small muted mt-1">This month</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="summary-card">
                    <div class="d-flex justify-content-between align-items-start mb-3"><span class="summary-label">Total
                            expenses</span><span class="summary-icon" style="background:#fff0ed;color:#c34c3a"><i
                                class="bi bi-arrow-up-right"></i></span></div>
                    <div class="summary-value" id="expenseValue">৳ <?= number_format($month_expense, 2) ?></div>
                    <div class="small muted mt-1">This month</div>
                </div>
            </div>
        </section>

        <section class="panel">
            <div
                class="panel-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <div>
                    <h2 class="h5 fw-bold mb-1">Recent transactions</h2>
                    <p class="small muted mb-0">View and manage your income and expenses.</p>
                </div>
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search muted"></i></span>
                        <input type="search" class="form-control border-start-0 ps-0" id="searchInput"
                            placeholder="Search transactions" aria-label="Search transactions">
                    </div>
                    <select class="form-select" id="typeFilter" aria-label="Filter transaction type"
                        style="min-width:140px">
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
                        <?php foreach ($user_transactions as $user_transaction) {
                            $isIncome = strtolower($user_transaction['type']) === 'income';
                            $iconStyle = $isIncome
                                ? 'background:#e8f7ef;color:#16834a'
                                : 'background:#fff5e8;color:#c17a16';
                        ?>
                            <tr data-type="<?= $isIncome ? 'income' : 'expense' ?>"
                                data-amount="<?= htmlspecialchars($user_transaction['amount']) ?>"
                                data-date="<?= htmlspecialchars($user_transaction['date']) ?>"
                                data-search="<?= htmlspecialchars(strtolower($user_transaction['description'] . ' ' . $user_transaction['category'])) ?>">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <span class="category-icon" style="<?= $iconStyle ?>">
                                            <i class="bi <?= htmlspecialchars(RenderIcon($user_transaction['category'])) ?>"></i>
                                        </span>
                                        <div>
                                            <div class="fw-semibold"><?= htmlspecialchars($user_transaction['description']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($user_transaction['category']) ?></td>
                                <td class="small muted"><?= htmlspecialchars($user_transaction['date']) ?></td>
                                <td>
                                    <span class="badge <?= $isIncome ? 'badge-income' : 'badge-expense' ?> rounded-pill px-2 py-2">
                                        <?= $isIncome ? 'Income' : 'Expense' ?>
                                    </span>
                                </td>
                                <td class="text-end fw-semibold <?= $isIncome ? 'text-success' : 'text-danger' ?>">
                                    <?= $isIncome ? '+' : '−' ?> ৳ <?= htmlspecialchars($user_transaction['amount']) ?>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-light text-secondary edit-btn" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-light text-danger delete-btn" title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="empty-state" id="emptyState"><i class="bi bi-search fs-2 d-block mb-2"></i>
                <div class="fw-semibold text-dark">No transactions found</div>
                <div class="small">Try changing your search or filter.</div>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 p-3 px-4 border-top"
                style="border-color:var(--line)!important">
                <span class="small muted" id="rowCount">Showing <?= $transaction_count ?> transaction<?= $transaction_count === 1 ? '' : 's' ?></span>
                <div class="d-flex gap-2"><button class="btn btn-sm btn-outline-secondary"
                        disabled>Previous</button><button class="btn btn-sm btn-primary">1</button><button
                        class="btn btn-sm btn-outline-secondary" disabled>Next</button></div>
            </div>
        </section>
        <div class="small muted text-center mt-4">MoneyTrack · Simple personal finance management</div>
    </main>

    <?php include("Modal/add_transaction_modal.php") ?>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="appToast" class="toast border-0 shadow" role="status" aria-live="polite" aria-atomic="true">
            <div class="toast-body d-flex align-items-center gap-2"><i
                    class="bi bi-check-circle-fill text-success"></i><span id="toastMessage">Done</span><button
                    type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/index.js"></script>
</body>

</html>