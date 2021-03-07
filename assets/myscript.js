

function submid_send_sms_callback(data) {
    console.log('test');
    var jdata = JSON.parse(data);

    if (jdata.success == 1) {


        var mess = jdata.message;
        var ref = jdata.refresh;
        var stuid = jdata.stuid;
        var iletimerkezi = jdata.iletimerkezi;
        var number = jdata.numara;
        var textmessage = jdata.mesaj;
        var sendurl = jdata.sendsmsurl;
        jQuery("#" + stuid + "response_div").html(mess);
        jQuery("#" + stuid + "response_div").css("background-color", "green");
        jQuery("#" + stuid + "response_div").css("color", "#ffffff");
        jQuery("#" + stuid + "response_div").css("padding", "20px");

        var imformdata = new FormData();
        imformdata.append('iletimerkezi', iletimerkezi);
        imformdata.append('numara', number);
        imformdata.append('mesaj', textmessage);
        getsmsdata(ref);
        posttophp(imformdata, sendurl, no_callback)
    }
}

function no_callback(data) {

    console.log('there is no callback');
    //var jdata = JSON.parse(data);

    //if (jdata.success == 1) {
    //}
}

function posttophp(ddd, sendurl, callback) {
    console.log('welcome to ajax');
    jQuery.ajax({

        url: sendurl,
        method: "POST",
        data: ddd,
        cache: false,
        processData: false,
        contentType: false,
        success: function (response) {
            callback(response);
        },
    });
}


function getlessonrecord(getUrl) {
    console.log('Start process for get lesson record');
    var fdilr = new FormData();
    fdilr.append('getlr', '1');
    fdilr.append('date', jQuery("#tarih").val());
    fdilr.append('teaid', jQuery("#teaid").val());
    posttophp(fdilr, getUrl, getlessonrecord_callback);
}

function getlessonrecord_callback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.success);
    console.log('test');
    if (jdata.success == 1) {
        console.log('mission success');
        var content = jdata.content;
        jQuery("#lessonrecords_cont").html(content);
    }
}


function renew_lr(prefix, getUrl) {
    console.log('Start process for get lesson record');
    var fdrnlr = new FormData();
    fdrnlr.append('renewlr', '1');
    fdrnlr.append('lrid', jQuery("#" + prefix + "lrid").val());
    fdrnlr.append('hders', jQuery("#" + prefix + "hders").val());
    fdrnlr.append('link', jQuery("#" + prefix + "link").val());
    posttophp(fdrnlr, getUrl, no_callback);
}

function gettimeline(getUrl) {
    console.log('Start process for get lesson record');
    var fdrntl = new FormData();
    fdrntl.append('gettl', '1');
    fdrntl.append('stuid', jQuery("#stuid").val());
    posttophp(fdrntl, getUrl, gettimeline_callback);
}

function gettimeline_callback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.success);
    console.log('test');
    if (jdata.success == 1) {
        console.log('mission success');
        var content = jdata.content;
        jQuery("#timeline_cont").html(content);
    }
}

function getExams(getUrl) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('getExam', '1');
    posttophp(fdrntl, getUrl, getExamsCallback);
}

function getExamsCallback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.success);
    console.log('test');
    if (jdata.success == 1) {
        console.log('mission success');
        var content = jdata.content;
        jQuery("table").append(content);
    }
}


function addExam(getUrl) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('getExam', '1');
    fdrntl.append('examName', jQuery("#examName").val());
    fdrntl.append('examDate', jQuery("#examDate").val());
    fdrntl.append('examType', jQuery("#examType").val());
    posttophp(fdrntl, getUrl, addExamCallback);
}

function addExamCallback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.success);
    console.log('test');
    if (jdata.success == 1) {
        console.log('mission success');
        var content = jdata.content;
        jQuery("table").prepend(content);
    }
}


//soruları getir
function getQuestions(getUrl) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('getExam', '1');
    fdrntl.append('exam', jQuery("#exam option:selected").val());
    posttophp(fdrntl, getUrl, getQuestionsCallback);
}

function getQuestionsCallback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.success);
    console.log('test');
    if (jdata.success == 1) {
        console.log('mission success');
        var content = jdata.content;
        jQuery("table").empty(content);
        jQuery("table").append(content);
    }
}

//soruları oluştur
function generateQuestions(getUrl) {
    console.log('Start process for generating questions');
    var fdrntl = new FormData();
    fdrntl.append('generateQuestions', '1');
    fdrntl.append('examid', jQuery("#examid").val());
    fdrntl.append('examtype', jQuery("#examtype").val());
    posttophp(fdrntl, getUrl, generateQuestionsCallback);
}

function generateQuestionsCallback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.success);
    console.log('test');
    if (jdata.success == 1) {
        console.log('mission success');
        var content = jdata.content;
        jQuery("table").append(content);
    }
}


//Öğrenci cevaplarını getir
function getStudentAnswer(getUrl) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('getSA', '1');
    fdrntl.append('exam', jQuery("#exam option:selected").val());
    posttophp(fdrntl, getUrl, getStudentAnswerCallback);
}

function getStudentAnswerCallback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.success);
    console.log('test');
    if (jdata.success == 1) {
        console.log('mission success');
        var content = jdata.content;
        var mainTitle = jdata.mainTitle;
        jQuery("#answerTable").empty(content);
        jQuery("#answerTable").append(mainTitle);
        jQuery("#answerTable").append(content);
    }
}


//Öğrenci cevaplarını oluştur
function generateSA(getUrl) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('genSA', '1');
    fdrntl.append('exam', jQuery("#exam option:selected").val());
    fdrntl.append('student', jQuery("#student option:selected").val());
    fdrntl.append('nameinfo', jQuery("#student option:selected").text());
    console.log(jQuery("#student option:selected").val());
    console.log(jQuery("#exam option:selected").val());
    posttophp(fdrntl, getUrl, generateSACallback);
}

function generateSACallback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log('test');
    var content = jdata.content;
    var name = jdata.name;
    var url = jdata.url;
    console.log(jdata.success);
    if (jdata.success == 1) {
        console.log('mission success');
        console.log(content);
        jQuery("#paragraf").text(name);
        jQuery("#paragraf").css("color", "#F53E00");
        getStudentAnswer(url);
    }
}

//Öğrenci cevaplarını oluştur
function setSA(getUrl, braid, stuid, examid) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('setSA', '1');
    fdrntl.append('branchID', braid);
    fdrntl.append('studentID', stuid);
    fdrntl.append('examID', examid);
    fdrntl.append('answers', jQuery("#" + braid + "-" + stuid).val());
    fdrntl.append('booktype', jQuery("#" + braid + "-" + stuid + "booktype").val());
    posttophp(fdrntl, getUrl, setSACallback);
}

function setSACallback(data) {
    console.log('mission also success');
    var jdata = JSON.parse(data);
    console.log('test');
    var content = jdata.content;
    console.log(jdata.success);
    if (jdata.success == 1) {
        console.log('mission success');
        console.log(content);
        jQuery("#paragraf").text(content);
        jQuery("#paragraf").css("color", "#F53E00");
    }
}


//Günlük Programı getir
function getLessons(getUrl, teacher) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('getLessons', '1');
    fdrntl.append('teacher', teacher);
    posttophp(fdrntl, getUrl, getLessonsCallback);
}

function getLessonsCallback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.success);
    console.log('test');
    var content = jdata.content;

    if (jdata.success == 1) {
        jQuery("#main-content").html(content);
    }
}

//ders baslat
function startLesson(getUrl, id) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('startLesson', '1');
    fdrntl.append('branch', jQuery("#branch" + id).val());
    fdrntl.append('stuid', jQuery("#stuid" + id).val());
    fdrntl.append('teaid', jQuery("#teaid" + id).val());
    fdrntl.append('hangisaat', jQuery("#hangisaat" + id).val());
    fdrntl.append('studentName', jQuery("#studentName" + id).val());
    fdrntl.append('who', id);

    posttophp(fdrntl, getUrl, startLessonCallback);

}

function startLessonCallback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.success);
    console.log('test');
    var content = jdata.content;
    var who = jdata.who;
    var lrid = jdata.lrid;
    if (jdata.g == 1) {
        jQuery("#recordID" + who + "0").val(jdata.a);
        jQuery("#recordID" + who + "1").val(jdata.b);
        jQuery("#recordID" + who + "2").val(jdata.c);
        jQuery("#recordID" + who + "3").val(jdata.d);
        jQuery("#recordID" + who + "4").val(jdata.e);
        jQuery("#recordID" + who + "5").val(jdata.f);
    }
    console.log(who);
    console.log(content);
    if (jdata.success == 1) {
        jQuery("#recordID" + who).val(lrid);
        var width = jQuery(window).width();
        if (width > 769) {
            jQuery(".lesson_cont ." + who + "a").animate({ width: "30%" }, function () {
                jQuery(".lesson_cont ." + who + "b").css("display", "block");
                jQuery("#baslat" + who).css("display", "none");
                jQuery("#bitir" + who).css("display", "block");
                jQuery("#bitir" + who).css("margin", "auto");
            });
        } else {
            jQuery(".lesson_cont ." + who + "b").css("display", "block");
            jQuery("#baslat" + who).css("display", "none");
            jQuery("#bitir" + who).css("display", "block");
            jQuery("#bitir" + who).css("margin", "auto");
        }
    }
}


function ac(who) {
    console.log(who);
    jQuery(".lesson_cont ." + who + "a").animate({ width: "30%" }, function () {
        jQuery(".lesson_cont ." + who + "b").fadeIn(1500);
    });
}


//soru çözümü baslat
function startQuestionProcess(getUrl, id) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('startLesson', '1');
    fdrntl.append('branch', jQuery("#qpbranch" + id).val());
    fdrntl.append('stuid', jQuery("#qpstuid" + id).val());
    fdrntl.append('teaid', jQuery("#qpteaid" + id).val());
    fdrntl.append('hangisaat', jQuery("#qphangisaat" + id).val());
    fdrntl.append('studentName', jQuery("#qpstudentName" + id).val());
    fdrntl.append('who', id);
    console.log(jQuery("#qpstuid" + id).val());
    posttophp(fdrntl, getUrl, startQuestionProcessCallback);

}

function startQuestionProcessCallback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.success);
    console.log('test');
    var content = jdata.content;
    var who = jdata.who;
    var lrid = jdata.lrid;
    console.log(who);
    console.log(content);
    console.log(lrid);
    if (jdata.success == 1) {
        jQuery("#qprecordID" + who).val(lrid);
        var width = jQuery(window).width();
        console.log('asdf')
        if (width > 830) {
            jQuery(".lesson_cont ." + who + "qpa").animate({ width: "30%" }, function () {
                jQuery(".lesson_cont ." + who + "qpb").fadeIn(500);
                jQuery("#qpkapat" + who).css("display", "block");
                jQuery("#qpbaslat" + who).css("display", "none");
                jQuery("#qpkapat" + who).css("margin", "auto");
            });
        } else {
            jQuery(".lesson_cont ." + who + "qpb").fadeIn(500);
            jQuery("#qpkapat" + who).css("display", "block");
            jQuery("#qpbaslat" + who).css("display", "none");
            jQuery("#qpkapat" + who).css("margin", "auto");
        }
    }
}


// radio gaga

function radioFunction(getUrl, id) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('radioSet', '1');
    fdrntl.append('who', id);
    fdrntl.append('homeworkStatus', jQuery("input[name=radiobtn" + id + "]:checked").val());
    fdrntl.append('recordID', jQuery("#recordID" + id).val());

    posttophp(fdrntl, getUrl, radioFunctionCallback);

}

function radioFunctionCallback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.who);
    console.log('test');
    var content = jdata.content;
    var who = jdata.who;
    if (jdata.success == 1) {
        jQuery("#" + content + who).prop('checked', true);
        setSms(who, '');
    }
}

// radio gagag

function radioFunctionG(getUrl, id, kontrol) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('radioSet', '1');
    fdrntl.append('who', id);
    fdrntl.append('kontrol', kontrol);
    fdrntl.append('homeworkStatus', jQuery("input[name=radiobtn" + id + kontrol + "]:checked").val());
    fdrntl.append('recordID', jQuery("#recordID" + id + kontrol).val());
    //console.log(kontrol);
    posttophp(fdrntl, getUrl, radioFunctionCallbackG);
}

function radioFunctionCallbackG(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    //console.log(jdata.kontrol);
    console.log(jdata.content);
    console.log('test');
    var content = jdata.content;
    var kontrol = jdata.kontrol;
    var who = jdata.who;
    if (jdata.success == 1) {
        jQuery("#" + content + who + kontrol).prop('checked', true);
        setSms(who, kontrol);
    }
}

// Set Lesson Status

function setLessonStatus(getUrl, id, kontrol) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('lessonStatusSet', '1');
    fdrntl.append('who', id);
    fdrntl.append('kontrol', kontrol);
    fdrntl.append('recordID', jQuery("#recordID" + id + kontrol).val());
    fdrntl.append('lessonStatus', jQuery("#lessonStatus" + id).val());
    console.log(jQuery("#recordID" + id).val());
    posttophp(fdrntl, getUrl, setLessonStatusCallback);

}

function setLessonStatusCallback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.who);
    console.log('test');
    var content = jdata.content;
    console.log(content);
    var who = jdata.who;
    var kontrol = jdata.kontrol;
    if (jdata.success == 1) {
        jQuery("#lessonStatus" + who + kontrol).val(content);
        jQuery("#lTG" + who + kontrol).html(content);
        setSms(who, kontrol);
    }
}

// Set Next Homework

function setNextHomework(getUrl, id, kontrol) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('lessonStatusSet', '1');
    fdrntl.append('who', id);
    fdrntl.append('kontrol', kontrol);
    fdrntl.append('recordID', jQuery("#recordID" + id + kontrol).val());
    fdrntl.append('nextHomework', jQuery("#nextHomework" + id).val());
    console.log('jo: ', jQuery("#nextHomework" + id).val());
    posttophp(fdrntl, getUrl, setNextHomeworkCallback);
}

function setNextHomeworkCallback(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.who);
    console.log('test');
    var content = jdata.content;
    console.log(content);
    var who = jdata.who;
    var kontrol = jdata.kontrol;
    if (jdata.success == 1) {
        jQuery("#nextHomework" + who + kontrol).val(content);
        jQuery("#nHG" + who + kontrol).html(content);
        setSms(who, kontrol);
    }
}

// Set qp

function setQP(getUrl, id) {
    console.log('Start process for get exams');
    var fdrntl = new FormData();
    fdrntl.append('setQP', '1');
    fdrntl.append('who', id);
    fdrntl.append('recordID', jQuery("#qprecordID" + id).val());
    fdrntl.append('tque', jQuery("#tque" + id).val());
    fdrntl.append('sque', jQuery("#sque" + id).val());
    posttophp(fdrntl, getUrl, setQPCallback);
}

function setQPCallback(data) {
    console.log('mission also success');
    var jdata = JSON.parse(data);
    console.log(jdata.who);
    console.log('test');
    var tasked = jdata.tasked;
    var sasked = jdata.sasked;
    console.log(content);
    var who = jdata.who;
    if (jdata.success == 1) {
        jQuery("#tque" + who).val(tasked);
        jQuery("#sque" + who).val(sasked);
    }
}

function setSms(who, kontrol) {
    var hour, lessonStatus, homeworkStatus, name, nextHomework;

    nextHomework = jQuery("#nextHomework" + who).val();
    lessonStatus = jQuery("#lessonStatus" + who).val();
    homeworkStatus = jQuery("input[name=radiobtn" + who + kontrol + "]:checked").val();
    hour = jQuery("#hour" + who).text();
    name = jQuery("#name" + who + kontrol).text();

    var smsText = name + ", " + hour + ", ";

    if (homeworkStatus == "tam") {
        smsText += "konu: " + lessonStatus + ". Önceki derste verilen ödev tam yapıldı. Bir sonraki ödev: " + nextHomework;
    } else if (homeworkStatus == "eksik") {
        smsText += "konu: " + lessonStatus + ". Önceki derste verilen ödev eksik/özensiz yapıldı. Bir sonraki ödev: " + nextHomework;
    } else if (homeworkStatus == "yok") {
        smsText += "konu: " + lessonStatus + ". Önceki derste verilen ödev yapılmadı. Bir sonraki ödev: " + nextHomework;
    } else if (homeworkStatus == "verilmedi") {
        smsText += "konu: " + lessonStatus + ". Bir sonraki ödev: " + nextHomework;
    } else if (homeworkStatus == "katilmadi") {
        smsText += "Öğrenci derse katılmadı. Bir sonraki ödev: " + nextHomework;
    }
    smsText += " İşleyen Zihinler "
    jQuery("#sms" + who + kontrol).text(smsText);
}

// finish lesson

function finishLesson(getUrl, id, kontrol) {
    if (confirm("SMS'leri Onayla ve Bitir")) {
        console.log('finishing');
        var fdrntl = new FormData();
        fdrntl.append('fin', '1');
        fdrntl.append('recordID', jQuery("#recordID" + id + kontrol).val());
        fdrntl.append('who', id);
        posttophp(fdrntl, getUrl, finishCallBack);
    }
}

function finishCallBack(data) {
    console.log('mission also success');
    var jdata = JSON.parse(data);
    var who = jdata.who;
    if (jdata.success == 1) {
        jQuery(".lesson_cont ." + who + "b").fadeOut(100, function () {
            console.log('kkk')
            var width = jQuery(window).width();
            if (width > 830) {
                jQuery(".lesson_cont ." + who + "a").animate({ width: "98%" });
            }
            jQuery(".lesson_cont ." + who + "a").css("background-color", "#F29BAB");
            jQuery("#baslat" + who).css("display", "none");
            jQuery("#bitir" + who).css("display", "none");
            // jQuery("#duzenle" + who).css("display", "block");
            // jQuery("#duzenle" + who).css("margin", "auto");
        });
    }
}



function changeStatus(who) {

    console.log('fisot')
    var width = jQuery(window).width();
    if (width > 830) {
        jQuery(".lesson_cont ." + who + "a").animate({ width: "30%" }, function () {
            jQuery(".lesson_cont ." + who + "b").fadeIn(500);
            jQuery(".lesson_cont ." + who + "a").css("background-color", "#F29BAB");
            jQuery("#kapat" + who).css("display", "block");
            jQuery("#duzenle" + who).css("display", "none");
            jQuery("#kapat" + who).css("margin", "auto");

        });
    } else {
        jQuery(".lesson_cont ." + who + "b").fadeIn(500);
        jQuery(".lesson_cont ." + who + "a").css("background-color", "#F29BAB");
        jQuery("#kapat" + who).css("display", "block");
        jQuery("#duzenle" + who).css("display", "none");
        jQuery("#kapat" + who).css("margin", "auto");
    }
}

function closeChange(who) {

    console.log('aa')
    jQuery(".lesson_cont ." + who + "b").fadeOut(100, function () {
        console.log('kkk')
        var width = jQuery(window).width();
        if (width > 830) {
            jQuery(".lesson_cont ." + who + "a").animate({ width: "98%" });
        }
        jQuery(".lesson_cont ." + who + "a").css("background-color", "#F29BAB");
        //    jQuery("#duzenle" + who).css("display", "block");
        jQuery("#kapat" + who).css("display", "none");
        //    jQuery("#duzenle" + who).css("margin", "auto");

    });
}

function closeQP(who) {

    console.log('aa')
    jQuery(".lesson_cont ." + who + "qpb").fadeOut(100, function () {
        console.log('kkk')
        var width = jQuery(window).width();
        if (width > 830) {
            jQuery(".lesson_cont ." + who + "qpa").animate({ width: "98%" });
        }
        jQuery(".lesson_cont ." + who + "qpa").css("background-color", "#F29BAB");
        jQuery("#qpduzenle" + who).css("display", "block");
        jQuery("#qpkapat" + who).css("display", "none");
        jQuery("#qpduzenle" + who).css("margin", "auto");

    });
}


function changeQP(who) {

    console.log('fisot')
    var width = jQuery(window).width();
    if (width > 830) {
        jQuery(".lesson_cont ." + who + "qpa").animate({ width: "30%" }, function () {
            jQuery(".lesson_cont ." + who + "qpb").fadeIn(500);
            jQuery(".lesson_cont ." + who + "qpa").css("background-color", "#F29BAB");
            jQuery("#qpkapat" + who).css("display", "block");
            jQuery("#qpduzenle" + who).css("display", "none");
            jQuery("#qpkapat" + who).css("margin", "auto");

        });
    } else {
        jQuery(".lesson_cont ." + who + "qpb").fadeIn(500);
        jQuery(".lesson_cont ." + who + "qpa").css("background-color", "#F29BAB");
        jQuery("#qpkapat" + who).css("display", "block");
        jQuery("#qpduzenle" + who).css("display", "none");
        jQuery("#qpkapat" + who).css("margin", "auto");
    }
}

function beforeSunrise(vwid, path) {
    var bwid = vwid - 1;
    var setLessonStatusURL = path + "/wp-content/plugins/meeting-parents/teacherspage/setLessonStatus.php/";
    var setNextHomeworkURL = path + "/wp-content/plugins/meeting-parents/teacherspage/setNextHomework.php/";
    var radioURL = path + "/wp-content/plugins/meeting-parents/teacherspage/radioSet.php/";
    for (let kontrol = 0; kontrol < 6; kontrol++) {
        homeworkStatus = jQuery("input[name=radiobtn" + bwid + kontrol + "]:checked").val();
        jQuery("#" + homeworkStatus + vwid + kontrol).prop('checked', true);
    }
    for (let index = 0; index < 6; index++) {
        radioFunctionG(radioURL, vwid, index);

    }

    var homework = jQuery("#lessonStatus" + bwid).val();
    jQuery("#lessonStatus" + vwid).val(homework);

    for (let index = 0; index < 6; index++) {
        setLessonStatus(setLessonStatusURL, vwid, index);
    }

    jQuery("#nextHomework" + vwid).val(jQuery("#nextHomework" + bwid).val());
    for (let index = 0; index < 6; index++) {
        setNextHomework(setNextHomeworkURL, vwid, index);
    }


}

function getSms(getUrl, date, day) {
    console.log("gettin SMS");
    var fdrntl = new FormData();
    fdrntl.append('getSMS', '1');
    fdrntl.append('tarih', date);
    fdrntl.append('bugun', day);
    console.log(date);
    console.log(day);

    posttophp(fdrntl, getUrl, getSmsCallBack);
}

function getSmsCallBack(data) {
    console.log("putting sms");
    var jdata = JSON.parse(data);
    var content = jdata.content;
    if (jdata.success == 1) {
        jQuery("#main-content").html(content);
    }
}

function generateSms(getUrl) {
    console.log("gettin SMS");
    var fdrntl = new FormData();
    fdrntl.append('generate', '1');
    posttophp(fdrntl, getUrl, generateSmsCallBack);
}

function generateSmsCallBack(data) {
    console.log("SMS setted");
    var jdata = JSON.parse(data);
    var content = jdata[1].sms;
    var kontrol = jdata.kontrol;
    if (jdata.success == 1) {
        for (let index = 0; index < kontrol; index++) {
            jQuery("#sms" + jdata[index].id).text(jdata[index].sms);
        }
    }
}

function deleteSms(getUrl, recordID) {
    if (confirm("Bu mesaj silinecek")) {
        console.log("gettin SMS");
        var fdrntl = new FormData();
        fdrntl.append('delete', '1');
        fdrntl.append('recordID', recordID);
        posttophp(fdrntl, getUrl, deleteSmsCallBack);
    }
}

function deleteSmsCallBack(data) {
    console.log("SMS deleted");
    var jdata = JSON.parse(data);
    var who = jdata.who;
    if (jdata.success == 1) {
        jQuery("#sms" + who).text(' ');
        jQuery("#" + who).css("background-color", "#ffd5eb");

    }
}

function sendSms(getUrl) {
    if (confirm("Tüm SMS'ler Gönderilecek")) {
        console.log("Sending SMS");
        var fdrntl = new FormData();
        fdrntl.append('send', '1');
        posttophp(fdrntl, getUrl, sendSmsCallBack);
    }
}

function sendSmsCallBack(data) {
    console.log("SMS ileti merkezine iletildi");
    var jdata = JSON.parse(data);
    var kontrol = jdata.kontrol;
    var url = jdata.url;
    if (jdata.success == 1) {
        for (let index = 0; index < kontrol; index++) {
            jQuery("#sent").append("<li>" + jdata[index].smsid + "</li>");
            jQuery("#sent").append("<li>" + jdata[index].number + "</li>");
            jQuery("#sent").append("<li>" + jdata[index].sms + "</li>");
            iletiMerkezi(url, jdata[index].sms, jdata[index].number, jdata[index].smsid);
        }
    }
}

function iletiMerkezi(getUrl, mesaj, numara, sms_id) {
    console.log("gettin SMS");
    var fdrntl = new FormData();
    fdrntl.append('iletimerkezi', '1');
    fdrntl.append('mesaj', mesaj);
    fdrntl.append('numara', numara);
    fdrntl.append('sms_id', sms_id);
    posttophp(fdrntl, getUrl, no_callback);
}


function changeClass(id, day, type, classroom) {
    console.log("changing class");
    var fdrntl = new FormData();
    fdrntl.append('change', '1');
    fdrntl.append('id', id);
    fdrntl.append('day', day);
    fdrntl.append('type', type);
    fdrntl.append('classroom', classroom);
    var getUrl = jQuery("#changeClassUrl").val();
    posttophp(fdrntl, getUrl, changeClassCallBack);
}

function changeClassCallBack(data) {
    console.log("changed class");
    var jdata = JSON.parse(data);
    var kontrol = jdata.kontrol;
    var id = jdata.id;
    var day = jdata.day;
    var classroom = jdata.classroom;
    if (jdata.success == 1) {
        jQuery("#class" + id + day).html(classroom);
    }
}

function erasmus(buyer, good, hangiders, classroom) {
    //console.log("Student Exchange Start");
    var fdrntl = new FormData();
    var getUrl = jQuery("#erasmusUrl").val();
    fdrntl.append('exchange', '1');
    fdrntl.append('buyer', buyer);
    fdrntl.append('good', good);
    fdrntl.append('hangisaat', hangiders);
    fdrntl.append('classroom', classroom);
    console.log(classroom);
    posttophp(fdrntl, getUrl, erasmusCallBack);
}
function erasmusCallBack(data) {
    console.log("Student Exchange Almost Done");
    var jdata = JSON.parse(data);
    var vwid = jdata.vwid;
    var teacher = jdata.teacher.trim();
    var day = jdata.day;
    var type = jdata.shop;
    var newClassRoom = jdata.newClass;
    var hour = jdata.hour;
    var cHoru = parseInt(hour);
    var realHour = hour.charAt(0);
    var student = jdata.student;
    if (jdata.success == 1) {
        console.log("vwid: " + vwid);
        console.log("teacher: " + teacher);
        console.log("day: " + day);
        console.log("hour: " + hour);
        console.log("student: " + student);
        var wohinGehtEs = "vw" + teacher + day + hour;
        var woherKommtDas = jQuery('#' + teacher + '-' + day + '-' + vwid + '-' + realHour + ' li:first input:first').attr('id');
        if (jQuery('#' + teacher + '-' + day + '-' + vwid + '-' + realHour + ' li:first input:first').val() == student) {
            let lastChar = woherKommtDas.substring(woherKommtDas.length - 1);
            if (lastChar == 1 && cHoru > 10) {
                var wKDT2 = woherKommtDas.substring(0, woherKommtDas.length - 1) + "2";
                console.log(wKDT2 + " -> " + woherKommtDas);
                jQuery('#' + wKDT2).attr('id', woherKommtDas);
            }
            jQuery('#' + teacher + '-' + day + '-' + vwid + '-' + realHour + ' li:first input:first').attr('id', wohinGehtEs);
            console.log("bu ilk saat");
            if (type == "lr") {
                jQuery('#' + teacher + '-' + day + '-' + vwid + '-' + realHour + ' li:first').find('.job-date').text(newClassRoom);
                let newClass = "job-block " + day + hour;
                jQuery('#' + teacher + '-' + day + '-' + vwid + '-' + realHour + ' li:first div:first').attr('class', newClass);
            } else if (type == "qp") {
                let newClass = "job-block-qp " + day + hour;
                jQuery('#' + teacher + '-' + day + '-' + vwid + '-' + realHour + ' li:first div:first').attr('class', newClass);
            }
        }
        else if (jQuery('#' + teacher + '-' + day + '-' + vwid + '-' + realHour + ' li:first input:first').val() != student) {
            console.log("eşit olmayan: " + student);
            woherKommtDas = jQuery('#' + teacher + '-' + day + '-' + vwid + '-' + realHour + ' li:nth-child(2) input:first').attr('id');
            let lastChar = woherKommtDas.substring(woherKommtDas.length - 1);
            if (lastChar == 1 && cHoru > 10) {
                var wKDT2 = woherKommtDas.substring(0, woherKommtDas.length - 1) + "2";
                jQuery('#' + wKDT2).attr('id', woherKommtDas);
            }
            jQuery('#' + teacher + '-' + day + '-' + vwid + '-' + realHour + ' li:nth-child(2) input:first').attr('id', wohinGehtEs);
            console.log("bu ikinci saat");
            if (type == "lr") {
                jQuery('#' + teacher + '-' + day + '-' + vwid + '-' + realHour + ' li:first').find('.job-date').text(newClassRoom);
                let newClass = "job-block " + day + hour;
                jQuery('#' + teacher + '-' + day + '-' + vwid + '-' + realHour + ' li:first div:first').attr('class', newClass);
            } else if (type == "qp") {
                let newClass = "job-block-qp " + day + hour;
                jQuery('#' + teacher + '-' + day + '-' + vwid + '-' + realHour + ' li:nth-child(2) div:first').attr('class', newClass);
            }
        }

        console.log("Geldiği Yer: " + woherKommtDas);
        console.log("Gittiği Yer: " + wohinGehtEs);
    }
}

function goHand(whatCanIDo) {
    console.log("handing: " + whatCanIDo);
    var fdrntl = new FormData();
    var getUrl = jQuery("#handlingUrl").val();
    fdrntl.append('handling', '1');
    fdrntl.append('knowledge', jQuery('#popValue').val());
    fdrntl.append('where', jQuery('#popId').val());
    fdrntl.append('whatCanIDo', whatCanIDo);
    fdrntl.append('day', jQuery('#popDay').val());
    fdrntl.append('popHour', jQuery('#popthisHour').val());
    var li = jQuery('#popLi').val();
    var teacher = jQuery('#' + li).attr('name');
    fdrntl.append('teacher', teacher);
    console.log(teacher);
    var branch = jQuery('#popBranch').val()
    var braid = 0;
    fdrntl.append('popNew', jQuery('#popNew').val());
    if (jQuery('input[name ="popBranchName"]').css('border') == "2px solid rgb(52, 199, 89)") {
        console.log('had brans');
        branch = jQuery('input[name ="popBranchName"]').val()
        braid = jQuery('#changeBranch').val();
    }
    fdrntl.append('changeBranchId', braid);
    fdrntl.append('popBranch', branch);
    if (jQuery('input[name ="popGroupName"]').css('border') == "2px solid rgb(52, 199, 89)") {
        console.log('this group');
        fdrntl.append('name', jQuery('input[name ="popGroupName"]').val());
        posttophp(fdrntl, getUrl, goHandCallBack);
    } else if (jQuery('input[name ="popStudentName"]').css('border') == "2px solid rgb(52, 199, 89)") {
        console.log('this notgroup');
        fdrntl.append('name', jQuery('input[name ="popStudentName"]').val());
        posttophp(fdrntl, getUrl, goHandCallBack);
    }
    if (whatCanIDo == "delete") {
        posttophp(fdrntl, getUrl, goHandCallBack);
    }


}

function goHandCallBack(data) {
    var jdata = JSON.parse(data);
    var shop = jdata.shop;
    var name = jdata.name;
    var gID = jdata.gID;
    var branch = jdata.branch;
    var whatCanIDo = jdata.whatCanIDo;
    var buyer = jdata.buyer;
    console.log("buyer: " + buyer);
    console.log("id: " +gID);
    var changeBranchId = jdata.changeBranchId;
    var neekle = jdata.neekle;
    console.log(neekle);
    console.log('geri');
    if (gID == "G") {
        var vwval = name;
    } else {
        var vwval = gID;
    }
    if (jdata.success == 1) {
        var li = jQuery('#popLi').val();
        var vwhour = jQuery('#popHour').val();
        var ul = jQuery('#popUl').val();
        var day = jQuery('#popDay').val();
        var hour = jQuery('#popthisHour').val();
        if (whatCanIDo == "delete") {
            jQuery('#' + li).remove();
        } else if (whatCanIDo == "change") {
            console.log('i can change');
            if (shop == "lr") {
                console.log('to lr');
                var valval = "lr| " + branch + " " + gID + " " + name;
                jQuery('#' + li).find('input[name ="virtualweek"]').val(vwval);
                jQuery('#' + li).find('input[name ="valueLesson"]').val(valval);
                jQuery('#' + li).find('.job-name').text(name);
                jQuery('#' + li).find('.user-email').text(branch);
                jQuery('#' + li).find('.edit-job-icon').attr("onclick", "openPop('" + branch + "','" + ul + "','" + li + "','" + gID + "','" + name + "','" + valval + "','" + day + "','" + hour + "','" + buyer + "','" + vwhour + "')");
            } else if (shop == "qp") {
                console.log('to qp');
                jQuery('#' + li).find('input[name ="virtualweek"]').val(vwval);
                jQuery('#' + li).find('input[name ="valueLesson"]').val("qp| " + gID);
                jQuery('#' + li).find('.job-name').text(name);
                jQuery('#' + li).find('.edit-job-icon').attr("onclick", "openPop('" + branch + "','" + ul + "','" + li + "','" + gID + "','" + name + "','" + valval + "','" + day + "','" + hour + "','" + buyer + "','" + vwhour + "')");
            }
        } else if (whatCanIDo == "lr") {
            if (jQuery("#" + ul + " li:first").attr('id') == li) {
                console.log('yes');
                jQuery("#" + ul + " li:nth-child(2)").remove();
            } else {
                console.log('no');
                jQuery("#" + ul + " li:first").remove();
            }
            jQuery('#' + li).attr('class', 'less ui-sortable-handle');
            jQuery('#' + li + " div:first").attr('class', 'job-block ' + day + hour);
            jQuery('#' + li).find('input[name ="virtualweek"]').val(vwval);
            jQuery('#' + li).find('input[name ="valueLesson"]').val("qp| " + gID);
            jQuery('#' + li).find('.job-name-block-qp').attr('class', 'job-name-block');
            jQuery('#' + li).find('.job-info-block-qp').attr('class', 'job-info-block');
            jQuery('#' + li).find('.job-name').text(name);
            jQuery('#' + li).find('.user-email').text(branch);
            jQuery('#' + li).find('.edit-job-icon').attr("onclick", "openPop('" + branch + "','" + ul + "','" + li + "','" + gID + "','" + name + "','" + valval + "','" + day + "','" + hour + "','" + buyer + "','" + vwhour + "')");
            jQuery('#' + li).find('.job-date').attr("onclick", "openClass('" + buyer + "','" + day + "','l')");
            jQuery('#' + li).find('.job-date').attr("id", "class" + buyer + day);
        } else if (whatCanIDo == "qp-1") {
            jQuery('#' + li).find('input[name ="virtualweek"]').val(vwval);
            jQuery('#' + li).find('input[name ="valueLesson"]').val("qp| " + gID);
            jQuery('#' + li).find('.job-name').text(name);
            jQuery('#' + li).find('.edit-job-icon').attr("onclick", "openPop('" + branch + "','" + ul + "','" + li + "','" + gID + "','" + name + "','" + valval + "','" + day + "','" + hour + "','" + buyer + "','" + vwhour + "')");
            jQuery('#' + li).find('.job-date').attr("onclick", "openClass('" + buyer + "','" + day + "','q')");
            jQuery('#' + li).find('.job-date').attr("id", "class" + buyer + day);
        } else if (whatCanIDo == "qp-2") {
            jQuery('#' + li).find('input[name ="virtualweek"]').val(vwval);
            jQuery('#' + li).find('input[name ="valueLesson"]').val("qp| " + gID);
            jQuery('#' + li).find('.job-name').text(name);
            jQuery('#' + li).find('.edit-job-icon').attr("onclick", "openPop('" + branch + "','" + ul + "','" + li + "','" + gID + "','" + name + "','" + valval + "','" + day + "','" + hour + "','" + buyer + "','" + vwhour + "')");
            jQuery('#' + li).find('.job-date').attr("onclick", "openClass('" + buyer + "','" + day + "','q')");
            jQuery('#' + li).find('.job-date').attr("id", "class" + buyer + day);
        }
        jQuery("#body").css("filter", "none");
        jQuery('#pop-up').fadeOut();
    }
}