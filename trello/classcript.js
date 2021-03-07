jQuery(function () {

  jQuery('.sort').sortable({
    connectWith: "ul",
    over: function (event, ui) { //triggered when sortable element hovers sortable list
      jQuery(this).css('padding-left', '20px');
      jQuery(this).css('padding-right', '20px');
      jQuery(this).css('border-color', 'red');
    },
    out: function (event, ui) { //event is triggered when a sortable item is moved away from a sortable list.
      jQuery(this).css('padding', '0');
      jQuery(this).css('border-color', 'rgb(55, 55, 54)');
    },
    start: function (event, ui) { //event is triggered when a sortable item is moved away from a sortable list.

    },
    stop: function (event, ui) { //event is triggered when a sortable item is moved away from a sortable list.

    },
    update: function (event, ui) {


    },
    receive: function (event, ui) { // event is triggered when an item from a connected sortable list has been dropped into another list
      console.log(jQuery(this).attr('id'));
      console.log(jQuery(ui.item).attr('id'));
      var id = jQuery(ui.item).attr('name');
      var itemInfo = jQuery(ui.item).attr('id');
      var type = jQuery(ui.item).attr('type');
      var day = jQuery("#today").val();
      var info = jQuery(this).attr('id');
      var classroom = "";
      for (var i = 6; i < 10; i++) {
        classroom += info.charAt(i);
      }

      if (info.charAt(5) != itemInfo.charAt(5)) {
        alert("Yanlış saat. Bu dersi " +  itemInfo.charAt(5) + ". saatin dersliklerine koyabilirsiniz");
        jQuery(ui.sender).append(jQuery(ui.item));
      }else{
        changeClass(id, day, type, classroom);
      }
    },
    revert: 100,
  });
});
