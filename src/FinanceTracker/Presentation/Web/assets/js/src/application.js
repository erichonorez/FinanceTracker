var AppRouter = Backbone.Router.extend({
    initialize: function() {
        this.transactions = new TransactionCollection();
        this.transactionFormView = new TransactionFormView({
            el: $('#transaction-form-container'),
            collection: this.transactions
        });
        this.transactionListView = new TransactionListView({
            el: $('#transaction-list-container'),
            collection: this.transactions
        });
    },
    routes:{
        "": "transactions"
    },
    transactions: function () {
        this.transactionListView.render();
        this.transactionFormView.render();
    }
});
var app;
$(document).ready(function() {
    // Router
    app = new AppRouter();
    Backbone.history.start();
});