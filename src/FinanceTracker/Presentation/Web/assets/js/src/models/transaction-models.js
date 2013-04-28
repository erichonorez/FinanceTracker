/**
 * Transaction entity
 * @type {*}
 */
window.Transaction = Backbone.Model.extend({
    isExpense: function() {
        return this.get('amount') < 0;
    }
});
/**
 * Transaction repository
 * @type {*}
 */
window.TransactionCollection =  Backbone.Collection.extend({
    model: Transaction,
    url: '/api/transactions'
});