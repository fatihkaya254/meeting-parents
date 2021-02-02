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
        success: function(response) {
            callback(response);
        },
    });
}

function get_full_sms(data) {
    console.log('mission also success');

    var jdata = JSON.parse(data);
    console.log(jdata.success);
    console.log('test');
    if (jdata.success == 1) {
        console.log('mission success');
        var content = jdata.content;
        jQuery("#wholesms").html(content);
        //jQuery("#wholesms").css("background-color","red");
    }
}

function getsmsdata(getUrl) {
    console.log('Selaaam');
    var fdi = new FormData();
    fdi.append('start', '1');
    posttophp(fdi, getUrl, get_full_sms);
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
    var processLR = jdata.processLR;

    if (jdata.success == 1) {
        jQuery("#main-content").html(content);
        jQuery("#progressbar").append(processLR);
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
        jQuery(".lesson_cont ." + who + "a").animate({ width: "30%" }, function() {
            jQuery(".lesson_cont ." + who + "b").css("display", "block");
        });
    }
}


function ac(who) {
    console.log(who);
    jQuery(".lesson_cont ." + who + "a").animate({ width: "30%" }, function() {
        jQuery(".lesson_cont ." + who + "b").css("display", "block");
    });
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
        setSms(who, '');
    }
}

function setSms(who, kontrol) {
    var hour, lessonStatus, homeworkStatus, name, nextHomework;

    nextHomework = jQuery("#nextHomework" + who + kontrol).val();
    lessonStatus = jQuery("#lessonStatus" + who + kontrol).val();
    homeworkStatus = jQuery("input[name=radiobtn" + who + kontrol + "]:checked").val();
    hour = jQuery("#hour" + who + kontrol).text();
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
    console.log("sms: " + smsText);
    jQuery("#sms" + who + kontrol).text(smsText);
}