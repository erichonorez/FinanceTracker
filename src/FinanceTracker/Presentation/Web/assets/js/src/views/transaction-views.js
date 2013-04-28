/**
 *
 * @type {*}
 */
window.TransactionListItemView = Backbone.View.extend({
    tagName: 'li',
    template: _.template($('#tpl-transactions-list-item').html()),
    render:function (eventName) {
        $(this.el).html(this.template({
            description: this.model.get('description'),
            amount: this.model.get('amount'),
            date: this.model.get('date'),
            isExpense: this.model.isExpense(),
            tags: this.model.get('tags')
        }));
        return this;
    }
});

/**
 * Transactions List View
 * @type {*}
 */
window.TransactionListView = Backbone.View.extend({
    initialize: function() {
        _.bindAll(this, "render");
        this.collection.bind("add", this.render);
        this.collection.bind("remove", this.render);
    },
    render:function (eventName) {
        $(this.el).empty();
        //render somthing when no data
        if (this.collection.length < 1) {
            $(this.el).append($('<span>No data</span>'));
            return;
        }
        //for each model in the collection append to the current
        //element the output of the TransactionListItemView
        _.each(this.collection.models, function (transaction) {
            $(this.el).append(new TransactionListItemView({
                model: transaction //the current model in the collection
            }).render().el);
        }, this);
        return this;
    }
});
/**
 * Transaction Form
 * @type {*}
 */
window.TransactionFormView = Backbone.View.extend({
    events: {
        "submit #transaction-form" : "save"
    },
    template: _.template($('#tpl-transactions-form').html()),
    render: function(event) {
        $(this.el).html(this.template);
        return this;
    },
    save: function(event) {
        event.preventDefault();
        //get form elements
        var descriptionElement = $(this.el).find('#transaction-form input[name=description]');
        var amountElement = $(this.el).find('#transaction-form input[name=amount]');
        var dateElement = $(this.el).find('#transaction-form input[name=date]');
        var tagElement = $(this.el).find('#transaction-form input[name=tags]');
        //create a task
        var transaction = new Transaction({
            description: descriptionElement.val(),
            amount: amountElement.val(),
            date: dateElement.val(),
            tags: _.without(tagElement.val().split(' '), '')
        });
        //add the task to the collection
        this.collection.add(transaction);
        //reset the form
        descriptionElement.val('');
        amountElement.val('');
        dateElement.val('');
        tagElement.val('');
    }
});
/**
 * Transation filter form
 */
 window.TransactionFilterForm = Backbone.View.Extend({
    events: {
        "click #transaction-filter" : "filter"
    },
    template: _.template($('#tpl-transactions-filter').html()),
    render: function(event) {
        $(this.el).render(this.template);
        return this;
    },
    filter: function(event) {
        event.preventDefault();
        //get form elements
        var startDate = $(this.el).find('#transaction-filter input[name=dateFrom]');
        var endDate = $(this.el).find('#transaction-filter input[name=dateTo]');
        var tags = $(this.el).find('#transaction-filter input[name=tags]');
        //send request to the api
    }
 });

 /**
  * Transaction summary
  */
  window.TransactionSummary = Backbone.View.Extend({
    render: function(event) {
        
    }
  });