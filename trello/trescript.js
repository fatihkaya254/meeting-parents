/************************************************************************************
      Sortable functions for Drag & Drop Interface
      *************************************************************************************/
jQuery(function () {
  jQuery(".sort").sortable({
    connectWith: "ul",
    over: function (event, ui) { //triggered when sortable element hovers sortable list
      jQuery(this).css('border', '1px solid #fff');
      jQuery(this).css('padding', '20px');
    },
    out: function (event, ui) { //event is triggered when a sortable item is moved away from a sortable list.
      jQuery(this).css('padding', '0');
      jQuery(this).css('border', 'none');
    },
    receive: function (event, ui) { // event is triggered when an item from a connected sortable list has been dropped into another list
      jQuery(this).css('padding', '0');
      jQuery(this).css('border', 'none');
      var sortedIDs = jQuery(this).sortable("toArray");
      if (jQuery(ui.item).attr('id') == sortedIDs[0]) {
        jQuery(ui.sender).append(jQuery("#"+sortedIDs[1]));
      }else{
        jQuery(ui.sender).append(jQuery("#"+sortedIDs[0]));
      }
      console.log(sortedIDs);
    },
    revert: 100,
  });
});