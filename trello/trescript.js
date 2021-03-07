/************************************************************************************
      Sortable functions for Drag & Drop Interface
      *************************************************************************************/
jQuery(function () {
  var a = 0;
  var op = 1;
  jQuery('.sort').sortable({
    connectWith: "ul",
    over: function (event, ui) { //triggered when sortable element hovers sortable list
      op = jQuery(this).css('opacity');
      jQuery(this).css('border', '3px solid #fff');
      jQuery(this).css('padding', '20px');
      a++;
    },
    out: function (event, ui) { //event is triggered when a sortable item is moved away from a sortable list.
      jQuery(this).css('padding', '0');
      jQuery(this).css('border', 'none');
    },
    start: function (event, ui) { //event is triggered when a sortable item is moved away from a sortable list.
      if (jQuery(ui.item).find('.job-block').attr('id') != undefined) {
        hover(jQuery(ui.item).find('.job-block'));
      } else if (jQuery(ui.item).find('.job-block-qp').attr('id') != undefined) {
        hover2(jQuery(ui.item).find('.job-block-qp'));

      }
    },
    stop: function (event, ui) { //event is triggered when a sortable item is moved away from a sortable list.
      stopHover();
      a = 0;
    },
    update: function (event, ui) {
      console.log("up");
      if (a == 1) {
        var thisAr = jQuery(this).sortable("toArray");
        var first = jQuery("#h" + thisAr[0]).val();
        var firstClass = jQuery('#' + thisAr[0]).find('.job-date').text();
        var other = jQuery("#h" + thisAr[1]).val();
        var otherClass = jQuery('#' + thisAr[1]).find('.job-date').text();
        var gidilenYer = jQuery(this).attr('id');
        console.log("First: " + first);
        console.log("Second: " + other);
        erasmus(gidilenYer, first, 1, firstClass);
        erasmus(gidilenYer, other, 2, otherClass);

      }

    },
    receive: function (event, ui) { // event is triggered when an item from a connected sortable list has been dropped into another list
      console.log("receive");
      jQuery(this).css('padding', '0');
      jQuery(this).css('border', 'none');
      var sortedIDs = jQuery(this).sortable("toArray");
      var senders = jQuery(ui.sender).sortable("toArray");
      console.log("Opacity: " + op);
      if (op < 1) {
        jQuery(ui.sender).append(jQuery(ui.item));
        var thisAr = jQuery(ui.sender).sortable("toArray");
        console.log(thisAr.length);
        if (thisAr.length == 2) {
          var first = jQuery("#h" + thisAr[0]).val();
          var firstClass = jQuery('#' + thisAr[0]).find('.job-date').text();
          var other = jQuery("#h" + thisAr[1]).val();
          var otherClass = jQuery('#' + thisAr[1]).find('.job-date').text();
          var gidilenYer = jQuery(ui.sender).attr('id');
          console.log("First: " + first);
          console.log("Second: " + other);
          erasmus(gidilenYer, first, 1, firstClass);
          erasmus(gidilenYer, other, 2, otherClass);
        }
      } else if (jQuery(ui.sender).attr('id') == 'handler') { //hand gönderiyorsa
        var handItemId = jQuery(ui.item).attr('id');
        var handItem = jQuery("#h" + handItemId).val();
        console.log("Item: " + handItem);
        var itemClass = jQuery('#' + handItemId).find('.job-date').text();
        console.log("Class: " + itemClass);
        var gidilenYer = jQuery(this).attr('id');
        console.log("Gidilenyer: " + gidilenYer);
        var indexV = sortedIDs.indexOf(handItemId) + 1;
        console.log("index: " + sortedIDs);
        let a = sortedIDs.length;
        if (jQuery(ui.item).attr('class') == 'less ui-sortable-handle') a++;
        if (a < 3) {
          goHand(handItem, gidilenYer, 'week', indexV);
        } else {
          console.log('else');
          jQuery(ui.sender).append(jQuery(ui.item));
        }
      } else if (jQuery(this).attr('id') == 'handler') { //hand'e gidiyorsa
        var handItemId = jQuery(ui.item).attr('id');
        var handItem = jQuery("#h" + handItemId).val();
        console.log(handItem);
        var nereden = jQuery(ui.sender).attr('id');
        goHand(handItem, nereden, 'hand', 1);
      } else if (jQuery(this).attr('id') != 'handler' && jQuery(ui.sender).attr('id') != 'handler') {
        if (jQuery(ui.item).attr('class') == 'less ui-sortable-handle') {
          if (jQuery(ui.item).attr('id') != sortedIDs[0] && sortedIDs[0] != undefined && jQuery("#" + sortedIDs[0]).attr('class') != 'que ui-sortable-handle') {
            console.log("this is 1st option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[0]));
            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var indexV = sortedIDs.indexOf(verilenID) + 1;
            //console.log("Verilen: " + jQuery("#h" + verilenID).val());
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[0]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var giden = jQuery("#h" + verilenID).val();
            var gidenClass = jQuery('#' + verilenID).find('.job-date').text();
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelenClass = jQuery('#' + alınanID).find('.job-date').text();
            var gelinenYer = jQuery(ui.sender).attr('id');
            erasmus(gidilenYer, giden, indexV, gidenClass);
            erasmus(gelinenYer, gelen, 2, gelenClass);
          }
          if (jQuery(ui.item).attr('id') != sortedIDs[1] && sortedIDs[1] != undefined && jQuery("#" + sortedIDs[1]).attr('class') != 'que ui-sortable-handle') {
            console.log("this is 2nd option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[1]));
            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var index = sortedIDs.indexOf(verilenID) + 1;
            //console.log("Verilen: " + jQuery("#h" + verilenID).val());
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[1]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var giden = jQuery("#h" + verilenID).val();
            var gidenClass = jQuery('#' + verilenID).find('.job-date').text();
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelenClass = jQuery('#' + alınanID).find('.job-date').text();
            var gelinenYer = jQuery(ui.sender).attr('id');
            erasmus(gidilenYer, giden, index, gidenClass);
            erasmus(gelinenYer, gelen, 2, gelenClass);
          }
          if (jQuery("#" + sortedIDs[1]).attr('class') == 'que ui-sortable-handle' || jQuery("#" + sortedIDs[0]).attr('class') == 'que ui-sortable-handle') {
            console.log("this is bloody option");
            if (jQuery("#" + sortedIDs[0]).attr('class') == 'less ui-sortable-handle') {
              jQuery(ui.sender).append(jQuery("#" + sortedIDs[1]));
              jQuery(ui.sender).append(jQuery("#" + sortedIDs[2]));
              var alınanID1 = jQuery("#" + sortedIDs[1]).attr('id');
              var alınanID2 = jQuery("#" + sortedIDs[2]).attr('id');
              var alınan1 = jQuery("#h" + alınanID1).val();
              var alınan1Class = jQuery('#' + alınanID1).find('.job-date').text();
              var alınan2 = jQuery("#h" + alınanID2).val();
              var alınan2Class = jQuery('#' + alınanID2).find('.job-date').text();
              var verilenID = jQuery(ui.item).attr('id');
              var verilen = jQuery("#h" + verilenID).val();
              var verilenClass = jQuery('#' + verilenID).find('.job-date').text();
              var gidilenYer = jQuery(this).attr('id');
              var gelinenYer = jQuery(ui.sender).attr('id');
              erasmus(gidilenYer, verilen, 1, verilenClass);
              erasmus(gelinenYer, alınan1, 1, alınan1Class);
              erasmus(gelinenYer, alınan2, 2, alınan2Class);
            } else if (jQuery("#" + sortedIDs[1]).attr('class') == 'less ui-sortable-handle') {
              jQuery(ui.sender).append(jQuery("#" + sortedIDs[0]));
              jQuery(ui.sender).append(jQuery("#" + sortedIDs[2]));
              var alınanID1 = jQuery("#" + sortedIDs[0]).attr('id');
              var alınanID2 = jQuery("#" + sortedIDs[2]).attr('id');
              var alınan1 = jQuery("#h" + alınanID1).val();
              var alınan1Class = jQuery('#' + alınanID1).find('.job-date').text();
              var alınan2Class = jQuery('#' + alınanID2).find('.job-date').text();
              var alınan2 = jQuery("#h" + alınanID2).val();
              var verilenID = jQuery(ui.item).attr('id');
              var verilen = jQuery("#h" + verilenID).val();
              var verilenClass = jQuery('#' + verilenID).find('.job-date').text();
              var gidilenYer = jQuery(this).attr('id');
              var gelinenYer = jQuery(ui.sender).attr('id');
              erasmus(gidilenYer, verilen, 1, verilenClass);
              erasmus(gelinenYer, alınan1, 1, alınan1Class);
              erasmus(gelinenYer, alınan2, 2, alınan2Class);
            } else if (jQuery("#" + sortedIDs[2]).attr('class') == 'less ui-sortable-handle') {
              jQuery(ui.sender).append(jQuery("#" + sortedIDs[0]));
              jQuery(ui.sender).append(jQuery("#" + sortedIDs[1]));
              var alınanID1 = jQuery("#" + sortedIDs[0]).attr('id');
              var alınanID2 = jQuery("#" + sortedIDs[1]).attr('id');
              var alınan1 = jQuery("#h" + alınanID1).val();
              var alınan2 = jQuery("#h" + alınanID2).val();
              var alınan1Class = jQuery('#' + alınanID1).find('.job-date').text();
              var alınan2Class = jQuery('#' + alınanID2).find('.job-date').text();
              var verilenID = jQuery(ui.item).attr('id');
              var verilen = jQuery("#h" + verilenID).val();
              var verilenClass = jQuery('#' + verilenID).find('.job-date').text();
              var gidilenYer = jQuery(this).attr('id');
              var gelinenYer = jQuery(ui.sender).attr('id');
              erasmus(gidilenYer, verilen, 1, verilenClass);
              erasmus(gelinenYer, alınan1, 1, alınan1Class);
              erasmus(gelinenYer, alınan2, 2, alınan2Class);
            }
          }

        } else if (jQuery(ui.item).attr('class') == 'que ui-sortable-handle' && sortedIDs[2] != undefined) {
          console.log("this is question");

          if (jQuery(ui.item).attr('id') == sortedIDs[0] && sortedIDs[0] != undefined && jQuery("#" + sortedIDs[1]).attr('class') != 'less ui-sortable-handle') {
            //console.log("this is q1st option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[1]));
            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var index = sortedIDs.indexOf(verilenID) + 1;
            //console.log("Verilen: " + jQuery("#h" + verilenID).val());
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[1]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var giden = jQuery("#h" + verilenID).val();
            var gidenClass = jQuery('#' + verilenID).find('.job-date').text();
            //  nereden geliyor
            var gerideKalan = jQuery("#h" + senders[0]).val();
            var gerideKalanClass = jQuery('#' + senders[0]).find('.job-date').text();
            var gerideS = gerideKalan.split("|");
            var whoisback = gerideS[1];
            var isFirst = gerideS[2] % 2;
            // nereden geliyor
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelenClass = jQuery('#' + alınanID).find('.job-date').text();
            var gelinenYer = jQuery(ui.sender).attr('id');
            if (!isFirst) erasmus(gelinenYer, gerideKalan, 1, gerideKalanClass);
            erasmus(gidilenYer, giden, index, gidenClass);
            erasmus(gelinenYer, gelen, 2, gelenClass);
          }
          if (jQuery(ui.item).attr('id') == sortedIDs[1] && sortedIDs[1] != undefined && jQuery("#" + sortedIDs[0]).attr('class') != 'less ui-sortable-handle') {
            console.log("this is q2nd option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[2]));
            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var index = sortedIDs.indexOf(verilenID) + 1;
            //console.log("Verilen: " + jQuery("#h" + verilenID).val());
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[2]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var giden = jQuery("#h" + verilenID).val();
            var gidenClass = jQuery('#' + verilenID).find('.job-date').text();
            //  nereden geliyor
            var gerideKalan = jQuery("#h" + senders[0]).val();
            var gerideKalanClass = jQuery('#' + senders[0]).find('.job-date').text();
            var gerideS = gerideKalan.split("|");
            var whoisback = gerideS[1];
            var isFirst = gerideS[2] % 2;
            // nereden geliyor
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelenClass = jQuery('#' + alınanID).find('.job-date').text();
            var gelinenYer = jQuery(ui.sender).attr('id');
            if (!isFirst) erasmus(gelinenYer, gerideKalan, 1, gerideKalanClass);
            erasmus(gidilenYer, giden, index, gidenClass);
            erasmus(gelinenYer, gelen, 2, gelenClass);
          }
          if (jQuery(ui.item).attr('id') == sortedIDs[2] && sortedIDs[2] != undefined && jQuery("#" + sortedIDs[0]).attr('class') != 'less ui-sortable-handle' && jQuery("#" + sortedIDs[1]).attr('class') != 'less ui-sortable-handle') {
            console.log("this is q3th option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[1]));
            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var index = sortedIDs.indexOf(verilenID) + 1;
            //console.log("Verilen: " + jQuery("#h" + verilenID).val());
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[1]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var giden = jQuery("#h" + verilenID).val();
            var gidenClass = jQuery('#' + verilenID).find('.job-date').text();
            //  nereden geliyor
            var gerideKalan = jQuery("#h" + senders[0]).val();
            var gerideKalanClass = jQuery('#' + senders[0]).find('.job-date').text();
            var gerideS = gerideKalan.split("|");
            var whoisback = gerideS[1];
            var isFirst = gerideS[2] % 2;
            // nereden geliyor
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelenClass = jQuery('#' + alınanID).find('.job-date').text();
            var gelinenYer = jQuery(ui.sender).attr('id');
            if (!isFirst) erasmus(gelinenYer, gerideKalan, 1, gerideKalanClass);
            erasmus(gidilenYer, giden, index, gidenClass);
            erasmus(gelinenYer, gelen, 2, gelenClass);
          }
        }
        if (jQuery(ui.item).attr('class') == 'que ui-sortable-handle') {
          if (jQuery("#" + sortedIDs[0]).attr('class') == 'less ui-sortable-handle') {
            console.log("this is q4th option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[0]));
            jQuery(this).append(jQuery("#" + senders[0]));

            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var index = sortedIDs.indexOf(verilenID) + 1;
            //console.log("Verilen 1: " + jQuery("#h" + verilenID).val());
            var giden = jQuery("#h" + verilenID).val();
            var gidenClass = jQuery('#' + verilenID).find('.job-date').text();
            //  nereden geliyor
            var gerideKalan = jQuery("#h" + senders[0]).val();
            var gerideKalanClass = jQuery('#' + senders[0]).find('.job-date').text();
            var gerideS = gerideKalan.split("|");
            var whoisback = gerideS[1];
            var isFirst = gerideS[2] % 2;
            // nereden geliyor
            verilenID = jQuery("#" + senders[0]).attr('id');
            //console.log("Verilen 2: " + jQuery("#h" + verilenID).val());
            var giden2 = jQuery("#h" + verilenID).val();
            var giden2Class = jQuery('#' + verilenID).find('.job-date').text();
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[0]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelenClass = jQuery('#' + alınanID).find('.job-date').text();
            var gelinenYer = jQuery(ui.sender).attr('id');
            if (!isFirst) erasmus(gelinenYer, gerideKalan, 1, gerideKalanClass);
            erasmus(gidilenYer, giden2, 2, giden2Class);
            erasmus(gidilenYer, giden, 1, gidenClass);
            erasmus(gelinenYer, gelen, 2, gelenClass);

          } else if (jQuery("#" + sortedIDs[1]).attr('class') == 'less ui-sortable-handle') {
            console.log("this is q4th option");
            jQuery(ui.sender).append(jQuery("#" + sortedIDs[1]));
            jQuery(this).append(jQuery("#" + senders[0]));

            //console.log("Veren: " + jQuery(ui.sender).attr('id'));
            var verilenID = jQuery(ui.item).attr('id');
            var index = sortedIDs.indexOf(verilenID) + 1;
            //console.log("Verilen 1: " + jQuery("#h" + verilenID).val());
            var giden = jQuery("#h" + verilenID).val();
            var gidenClass = jQuery('#' + verilenID).find('.job-date').text();
            //  nereden geliyor
            var gerideKalan = jQuery("#h" + senders[0]).val();
            var gerideKalanClass = jQuery('#' + senders[0]).find('.job-date').text();
            var gerideS = gerideKalan.split("|");
            var whoisback = gerideS[1];
            var isFirst = gerideS[2] % 2;
            // nereden geliyor
            verilenID = jQuery("#" + senders[0]).attr('id');
            var index2 = sortedIDs.indexOf(verilenID) + 1;
            //console.log("Verilen 2: " + jQuery("#h" + verilenID).val());
            var giden2 = jQuery("#h" + verilenID).val();
            var giden2Class = jQuery('#' + verilenID).find('.job-date').text();
            //console.log("Alan: " + jQuery(this).attr('id'));
            var alınanID = jQuery("#" + sortedIDs[1]).attr('id');
            //console.log("Alınan: " + jQuery("#h" + alınanID).val());
            var gidilenYer = jQuery(this).attr('id');
            var gelen = jQuery("#h" + alınanID).val();
            var gelenClass = jQuery('#' + alınanID).find('.job-date').text();
            var gelinenYer = jQuery(ui.sender).attr('id');
            if (!isFirst) erasmus(gelinenYer, gerideKalan, 1, gerideKalanClass);
            erasmus(gidilenYer, giden2, 2, giden2Class);
            erasmus(gidilenYer, giden, 1, gidenClass);
            erasmus(gelinenYer, gelen, 2, gelenClass);

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

function hover(hv) {
  var hoverObject = jQuery(hv).attr('id');
  console.log(hoverObject);
  var harray = hoverObject.split("-");
  var id = harray[2];
  var name = harray[1];
  if (id == "G") id = name;
  if (jgroups[id] == undefined) jgroups[id] = "yok";
  // console.log(jgroups[id]);
  for (var key in jTeacherList) {
    if (jTeacherList.hasOwnProperty(key)) {
      for (let day = 0; day < days.length; day++) {
        let gun = days[day];
        for (let i = 1; i < 10; i++) {
          if (jQuery("#vw" + key + gun + i).val() == id || jQuery("#vw" + key + gun + i).val() == name || jQuery("#vw" + key + gun + i).val() == jgroups[id]) {
            var kontrolClass = "job-block " + gun + i;
            if (jQuery(hv).attr('class') != kontrolClass) {
              jQuery(".ul" + gun + i).css("opacity", "0.2");
              //console.log(gun + i + " = " + jQuery("#vw" + key + gun + i).val());
            }

          }
          for (let j = 1; j < 3; j++) {
            if (jQuery("#vw" + key + gun + i + j).val() == id || jQuery("#vw" + key + gun + i + j).val() == name) {
              jQuery(".ul" + gun + i).css("opacity", "0.2");
              //  console.log(gun + i + " = " + jQuery("#vw" + key + gun + i + j).val());

            }
          }
        }
      }
    }
  }
  Object.keys(jgroups).forEach(function (element) {
    if (jgroups[element] == name) {
      id = element;
      // console.log(jnames[element] + ": " + id);
      for (var key in jTeacherList) {
        if (jTeacherList.hasOwnProperty(key)) {
          for (let day = 0; day < days.length; day++) {
            let gun = days[day];
            for (let i = 1; i < 10; i++) {
              if (jQuery("#vw" + key + gun + i).val() == id) {
                var kontrolClass = "job-block " + gun + i;
                jQuery(".ul" + gun + i).css("opacity", "0.2");
                //  console.log(gun + i + " = " + jQuery("#vw" + key + gun + i).val());

              }
              for (let j = 1; j < 3; j++) {
                if (jQuery("#vw" + key + gun + i + j).val() == id) {
                  jQuery(".ul" + gun + i).css("opacity", "0.2");
                  //    console.log(gun + i + " = " + jQuery("#vw" + key + gun + i + j).val());

                }
              }
            }
          }
        }
      }
    }
  });
}

function hover2(hv) {
  var hoverObject = jQuery(hv).attr('id');
  var harray = hoverObject.split("-");
  var id = harray[2];
  var name = harray[1];
  if (id == "G") id = name;
  if (jgroups[id] == undefined) jgroups[id] = "yok";
  //   console.log(jgroups[id]);
  for (var key in jTeacherList) {
    if (jTeacherList.hasOwnProperty(key)) {
      for (let day = 0; day < days.length; day++) {
        let gun = days[day];
        for (let i = 1; i < 10; i++) {
          if (jQuery("#vw" + key + gun + i).val() == id || jQuery("#vw" + key + gun + i).val() == name || jQuery("#vw" + key + gun + i).val() == jgroups[id]) {
            var kontrolClass = "job-block-qp " + gun + i;
            if (jQuery(hv).attr('class') != kontrolClass) {
              jQuery(".ul" + gun + i).css("opacity", "0.2");
              // console.log(gun + i + " = " + jQuery("#vw" + key + gun + i).val());
            }

          }
          for (let j = 1; j < 3; j++) {
            if (jQuery("#vw" + key + gun + i + j).val() == id || jQuery("#vw" + key + gun + i + j).val() == name) {
              var kontrolClass = "job-block-qp " + gun + i + j;
              if (jQuery(hv).attr('class') != kontrolClass) {
                jQuery(".ul" + gun + i).css("opacity", "0.2");
                // console.log(gun + i + " = " + jQuery("#vw" + key + gun + i + j).val());
              }
            }
          }
        }
      }
    }
  }
}

function stopHover() {
  jQuery(".sort").css("opacity", "1");
  jQuery(".sort").css("opacity", "1");
}