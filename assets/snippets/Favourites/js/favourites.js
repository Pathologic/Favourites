var Favourites = {
    connector: '',
    add: function(id) {
        $.post(this.connector, {action: 'add', id: id}, function(response) {
            $('.favourites-count').text(response);
        });
    },
    remove: function(id) {
        $.post(this.connector, {action: 'remove', id: id}, function(response) {
            $('.favourites-count').text(response);
        });
    }
};
$(document).on('click', '.favourites', function(e){
    e.preventDefault();
    var btn = $(e.target);
    var id = btn.data('id');
    if (btn.hasClass('active')) {
        Favourites.remove(id);
        btn.removeClass('active');
    } else {
        Favourites.add(id);
        btn.addClass('active');
    }
});
