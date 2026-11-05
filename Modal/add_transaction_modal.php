 <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content border-0 shadow" id="transactionForm">
                <div class="modal-header border-bottom-0 pb-0">
                    <div>
                        <h2 class="modal-title h5 fw-bold" id="transactionModalLabel">Add transaction</h2>
                        <p class="small muted mb-0">Record money coming in or going out.</p>
                    </div><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4">
                    <div class="mb-3"><label class="form-label fw-semibold" for="description">Description</label><input class="form-control" id="description" required maxlength="100" placeholder="e.g. Grocery shopping"></div>
                    <div class="row g-3">
                        <div class="col-sm-6"><label class="form-label fw-semibold" for="amount">Amount (৳)</label><input class="form-control" id="amount" type="number" min="0.01" step="0.01" required placeholder="0.00"></div>
                        <div class="col-sm-6"><label class="form-label fw-semibold" for="transactionType">Type</label><select class="form-select" id="transactionType">
                                <option value="expense">Expense</option>
                                <option value="income">Income</option>
                            </select></div>
                        <div class="col-sm-6"><label class="form-label fw-semibold" for="category">Category</label><select class="form-select" id="category">
                                <option>Food</option>
                                <option>Salary</option>
                                <option>Utilities</option>
                                <option>Transport</option>
                                <option>Shopping</option>
                                <option>Freelance</option>
                                <option>Other</option>
                            </select></div>
                        <div class="col-sm-6"><label class="form-label fw-semibold" for="transactionDate">Date</label><input class="form-control" id="transactionDate" type="date" required></div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary px-4">Save transaction</button></div>
            </form>
        </div>
    </div>