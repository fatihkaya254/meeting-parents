/************************************************************************************
      Sortable functions for Drag & Drop Interface
      *************************************************************************************/
jQuery(function () {
  jQuery('.sort').sortable({
    connectWith: "ul",
    over: function (event, ui) { //triggered when sortable element hovers sortable list
      jQuery(this).css('border', '3px solid #fff');
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
      var senders = jQuery(ui.sender).sortable("toArray");
      //console.log(sortedIDs);
      console.log(jQuery('ul#'+jQuery(ui.sender).first().attr('id')+ 'li:first').attr('id'));
      if (jQuery(this).attr('id') != 'handler') {
        if (jQuery(ui.item).attr('class') == 'less ui-sortable-handle') {
          if (jQuery(ui.item).attr('id') != sortedIDs[0] && sortedIDs[0] != undefined) {
            //console.log("this is 1st option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[0]));
            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var indexV = sortedIDs.indexOf(verilenID);
            //console.log("Verilen: " + jQuery("#h" + verilenID).val());
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[0]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var giden = jQuery("#h" + verilenID).val();
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelinenYer = jQuery(ui.sender).attr('id');
            erasmus(gidilenYer, giden, indexV);
            erasmus(gelinenYer, gelen, 2);
          }
          if (jQuery(ui.item).attr('id') != sortedIDs[1] && sortedIDs[1] != undefined) {
            //console.log("this is 2nd option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[1]));
            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var index = sortedIDs.indexOf(verilenID);
            //console.log("Verilen: " + jQuery("#h" + verilenID).val());
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[1]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var giden = jQuery("#h" + verilenID).val();
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelinenYer = jQuery(ui.sender).attr('id');
            erasmus(gidilenYer, giden, index);
            erasmus(gelinenYer, gelen, 2);
          }
          if (jQuery(ui.item).attr('id') != sortedIDs[2] && sortedIDs[2] != undefined) {
            //console.log("this is 3th option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[2]));
            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            //console.log("Verilen: " + jQuery("#h" + verilenID).val());
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[2]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var giden = jQuery("#h" + verilenID).val();
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelinenYer = jQuery(ui.sender).attr('id');
            erasmus(gidilenYer, giden, index);
            erasmus(gelinenYer, gelen, 2);
          }
        } else if (jQuery(ui.item).attr('class') == 'que ui-sortable-handle' && sortedIDs[2] != undefined) {
          //console.log("this is question");

          if (jQuery(ui.item).attr('id') == sortedIDs[0] && sortedIDs[0] != undefined) {
            //console.log("this is q1st option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[1]));
            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var index = sortedIDs.indexOf(verilenID);
            //console.log("Verilen: " + jQuery("#h" + verilenID).val());
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[1]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var giden = jQuery("#h" + verilenID).val();
            //  nereden geliyor
            var sGiden = giden.split("|");
            var gidenSaat = sGiden[2];
            var ilkSaatMi = gidenSaat % 2;
            console.log(ilkSaatMi);
            // nereden geliyor
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelinenYer = jQuery(ui.sender).attr('id');
            erasmus(gidilenYer, giden, index);
            erasmus(gelinenYer, gelen, 2);
          }
          if (jQuery(ui.item).attr('id') == sortedIDs[1] && sortedIDs[1] != undefined) {
            //console.log("this is q2nd option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[2]));
            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var index = sortedIDs.indexOf(verilenID);
            //console.log("Verilen: " + jQuery("#h" + verilenID).val());
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[2]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var giden = jQuery("#h" + verilenID).val();
            //  nereden geliyor
            var sGiden = giden.split("|");
            var gidenSaat = sGiden[2];
            var ilkSaatMi = gidenSaat % 2;
            console.log(ilkSaatMi);
            // nereden geliyor
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelinenYer = jQuery(ui.sender).attr('id');
            erasmus(gidilenYer, giden, index);
            erasmus(gelinenYer, gelen, 2);
          }
          if (jQuery(ui.item).attr('id') == sortedIDs[2] && sortedIDs[2] != undefined) {
            //console.log("this is q3th option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[1]));
            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var index = sortedIDs.indexOf(verilenID);
            //console.log("Verilen: " + jQuery("#h" + verilenID).val());
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[1]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var giden = jQuery("#h" + verilenID).val();
            //  nereden geliyor
            var sGiden = giden.split("|");
            var gidenSaat = sGiden[2];
            var ilkSaatMi = gidenSaat % 2;
            console.log(ilkSaatMi);
            // nereden geliyor
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelinenYer = jQuery(ui.sender).attr('id');
            erasmus(gidilenYer, giden, index);
            erasmus(gelinenYer, gelen, 2);
          }
        }
        if (jQuery(ui.item).attr('class') == 'que ui-sortable-handle') {
          //console.log("this is q4th option");
          if (jQuery("#" + sortedIDs[0]).attr('class') == 'less ui-sortable-handle') {
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[0]));
            jQuery(this).append(jQuery("#" + senders[0]));

            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var index = sortedIDs.indexOf(verilenID);
            //console.log("Verilen 1: " + jQuery("#h" + verilenID).val());
            var giden = jQuery("#h" + verilenID).val();
            //  nereden geliyor
            var sGiden = giden.split("|");
            var gidenSaat = sGiden[2];
            var ilkSaatMi = gidenSaat % 2;
            console.log(ilkSaatMi);
            // nereden geliyor
            verilenID = jQuery("#" + senders[0]).attr('id');
            var index2 = sortedIDs.indexOf(verilenID);
            //console.log("Verilen 2: " + jQuery("#h" + verilenID).val());
            var giden2 = jQuery("#h" + verilenID).val();
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[0]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelinenYer = jQuery(ui.sender).attr('id');
            erasmus(gidilenYer, giden2, index2);
            erasmus(gidilenYer, giden, index);
            erasmus(gelinenYer, gelen, 2);

          } else if (jQuery("#" + sortedIDs[1]).attr('class') == 'less ui-sortable-handle') {
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[1]));
            jQuery(this).append(jQuery("#" + senders[0]));

            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var index = sortedIDs.indexOf(verilenID);
            //console.log("Verilen 1: " + jQuery("#h" + verilenID).val());
            var giden = jQuery("#h" + verilenID).val();
            //  nereden geliyor
            var sGiden = giden.split("|");
            var gidenSaat = sGiden[2];
            var ilkSaatMi = gidenSaat % 2;
            console.log(ilkSaatMi);
            // nereden geliyor
            verilenID = jQuery("#" + senders[0]).attr('id');
            var index2 = sortedIDs.indexOf(verilenID);
            //console.log("Verilen 2: " + jQuery("#h" + verilenID).val());
            var giden2 = jQuery("#h" + verilenID).val();
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[1]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelinenYer = jQuery(ui.sender).attr('id');

            erasmus(gidilenYer, giden2, index2);
            erasmus(gidilenYer, giden, index);
            erasmus(gelinenYer, gelen, 2);

          }
        }
      }
    },
    revert: 100,
  });
});

function showBusiness() {
  var searchIDs = jQuery("input:checkbox:checked").map(function () {
    return jQuery(this).val();
  }).get(); // <----
  //console.log(searchIDs);
  searchIDs.forEach(a => {

    jQuery("#body" + a).slideDown(function () {
      jQuery("#teacher" + a).slideDown();

    });

  });
  var searchIDs = jQuery("input:checkbox:not(:checked)").map(function () {
    return jQuery(this).val();
  }).get(); // <----
  //console.log(searchIDs);
  searchIDs.forEach(a => {

    jQuery("#body" + a).slideUp(function () {
      jQuery("#teacher" + a).slideUp();

    });
  });
}

