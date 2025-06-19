

function showError(e, t) {
    0 === $("#error" + e).length && $(".error-container").append("<span style='display: block' id=error" + e + "><span class='error-icon'></span><span> " + t + "</span></span>")
}

function hideError(e) {
    $("#error" + e).remove()
}

function hideAllErrors() {
    hideError(1), hideError(2), hideError(3)
}

function createTable() {
    formData = new FormData;
    for (let e = 0; e < $("#file-upload").prop("files").length; e++) formData.append("files[]", $("#file-upload").prop("files")[e])
}

function addFile() {
    for (let e = 0; e < $("#add-file").prop("files").length; e++) formData.append("files[]", $("#add-file").prop("files")[e])
}

function updateTable() {
    const e = ["srt", "vtt", "stl", "sbv", "sub", "ass"];
    let t = 0;
    const n = formData.getAll("files[]").length;
    let o = !1;
    $("tbody").html("");
    for (let n = 0; n < formData.getAll("files[]").length; n++) {
        let l = [];
        const i = formData.getAll("files[]")[n];
        l.extension = i.name.split(".").pop(), l.name = i.name.replace(/C:\\fakepath\\/i, "").replace(/\.[^/.]+$/, "").replace(/[^a-zA-Z0-9 ]/g, " "), l.size = Math.trunc(i.size / Math.pow(1e3, 1)), t += l.size, e.includes(l.extension) ? $("tbody").append('<tr>                        <td><img src="resources/images/checked.svg"></td>                        <td>' + l.name + "</td>                        <td>" + l.size + " KB</td>                        <td>." + l.extension + '</td>                        <td><button class="delete">' + n + "<button</td>               </tr>") : (showError(3, "There are one or more invalid files!"), o = !0, $("tbody").append("<tr style='border: solid 2px #B00020'>                        <td><img src=\"resources/images/error.svg\"></td>                        <td>" + l.name + "</td>                        <td>" + l.size + " KB</td>                        <td>." + l.extension + '</td>                        <td><button class="delete">' + n + "<button</td>               </tr>"))
    }
    t > 1e3 ? ($("#files_info_size").css("color", "#B00020"), showError(1, "You have exceeded the maximum allowed size!"), o = !0) : ($("#files_info_size").css("color", "#616161"), hideError(1)), o || hideError(3), n > 20 ? ($("#files_info_amount").css("color", "#B00020"), showError(2, "You have exceeded the maximum number of files allowed"), o = !0) : ($("#files_info_amount").css("color", "#616161"), hideError(2)), $("#files_amount").text(n), $("#files_size").text(t), o ? $("#next-button").prop("disabled", !0) : 0 === document.getElementsByTagName("tbody")[0].childNodes.length ? $("#next-button").prop("disabled", !0) : $("#next-button").prop("disabled", !1)
}

function getOriginalText() {
    let e = [];
    const t = document.getElementById("text-no-translated").children;
    for (let n = 0; n < t.length; n++){
        e[n] = window.Subtitle.parse(t[n].textContent);
    }
    return e
}

function putSubtitlesToTranslate(e) {
    const t = document.getElementById("text-to-translate");
    for (i = 0; i < e.length; i++) {
        const n = document.createElement("div"),

        o = e[i];
        for (let e = 0; e < o.length; e++) n.appendChild(document.createTextNode(o[e].text)), t.appendChild(n)
    }
}

function isTranslated() {
    let e = document.getElementById("text-to-translate").childNodes;
    for (let t = 0; t < e.length; t++) {
        let n = e[t].childNodes;
        for (let e = 0; e < n.length; e++)
            if ("FONT" != n[e].tagName) return !1
    }
    return !0
}

function saveTranslatedText(e) {
    let t = document.getElementById("text-to-translate").childNodes;
    for (let l = 0; l < t.length; l++) {
        let i = t[l].childNodes;
        var text = [];
        for (let t = 0; t < i.length; t++)  e[l][t].text = i[t].textContent;
        var n = document.getElementById("form-files"),
            o = document.createElement("input");
        o.setAttribute("type", "hidden"), o.setAttribute("name", "translated_text[]"),
        o.setAttribute("value", window.Subtitle.stringify(e[l])), n.appendChild(o)
    }
    $("#translate-button").hide();
    let l = document.createElement("button");
    let m = document.createElement("button");
    l.setAttribute("id", "download-button"),
    l.setAttribute("class", "red-button translate-button"),
    l.innerHTML = '<img src="resources/images/download_cloud.svg" width="24" height="15"/>\n<span style="margin-left: 4px;">DOWNLOAD</span>',
    l.id = "download-button",
    document.getElementById("button-container").appendChild(l),
    $(".tool-content-title")[0].innerText = "Download",
    $(".page-description")[1].innerText = "The translation has finished successfully! Click on the button below to download your file.", $(".goog-te-gadget").hide(), document.getElementsByClassName("steps2")[0].style.backgroundImage = "url('resources/images/progress_3.svg')"
}

function saveToEdit(e) {
    let t = document.getElementById("text-to-translate").childNodes;
    for (let l = 0; l < t.length; l++) {
        let i = t[l].childNodes;
        for (let t = 0; t < i.length; t++) e[l][t].text = i[t].textContent;
        var n = document.getElementById("form-files"),
            o = document.createElement("input");
        o.setAttribute("type", "hidden"), o.setAttribute("name", "translated_text[]"), o.setAttribute("value", window.Subtitle.stringify(e[l])), n.appendChild(o)
    }
}

function deleteAll() {
    $.ajax({
        url: "../delete_all.php",
        type: "GET",
        success: function(e) {}
    })
}

function uploadToEdit() {
    formData = new FormData;
    for (let e = 0; e < $("#file-upload-edit").prop("files").length; e++) formData.append("files[]", $("#file-upload-edit").prop("files")[e]);
    $.ajax({
        url: "../src/services/upload_file.php",
        data: formData,
        processData: !1,
        contentType: !1,
        type: "POST",
        success: function(e) {
            window.location.href = "edit.php?id=" + e
        },
        error: function() {
            alert("There are one or more errors!")
        }
    })
}

function getTextToEdit() {
    let e = [];
    const t = document.getElementById("text-to-edit").children;
    for (let n = 0; n < t.length; n++) "SPAN" != t[n].tagName && e.push(window.Subtitle.parse(t[n].textContent));
    return e
}

function getNamesToEdit() {
    let e = [];
    const t = document.getElementById("text-to-edit").children;
    for (let n = 0; n < t.length; n++) "SPAN" == t[n].tagName && e.push(t[n].textContent);
    return e
}

function generateSelectToEdit() {
    let e = getNamesToEdit(),
        t = $("#edit-file-select");
    for (let n = 0; n < e.length; n++) t.append(new Option(e[n], n))
}

function saveEditedText() {
    let e = document.getElementById("text-to-translate").childNodes;
    for (let o = 0; o < e.length; o++) {
        let l = e[o].childNodes;
        for (let e = 0; e < l.length; e++) subtitles[o][e].text = l[e].textContent;
        var t = document.getElementById("upload-form"),
            n = document.createElement("input");
        n.setAttribute("type", "hidden"), n.setAttribute("name", "translated_text[]"), n.setAttribute("value", window.Subtitle.stringify(subtitles[o])), t.appendChild(n)
    }
    $(".table-container").hide(), $(".tool-nav-container").hide();
    let o = document.createElement("button");
    o.setAttribute("id", "download-button"), o.setAttribute("class", "red-button translate-button"), o.innerHTML = '<img src="resources/images/download_cloud.svg" width="24" height="15"/>\n                    <span style="margin-left: 4px;">DOWNLOAD</span>', o.id = "download-button";
    let l = document.getElementsByClassName("tool-content")[0],
        i = document.createElement("div");
    i.setAttribute("id", "button-container"), i.setAttribute("style", "width: 100%; text-align: center; margin-top: 20px"), i.appendChild(o), l.appendChild(i);
    let a = document.createElement("div");
    a.setAttribute("class", "steps2"), l.appendChild(a), l.insertBefore(a, l.firstChild), document.getElementsByClassName("steps2")[0].style.backgroundImage = "url('resources/images/progress_3.svg')";
    let d = document.createElement("button");
    d.setAttribute("class", "return-button"), d.setAttribute("id", "return-button-translate"), d.setAttribute("style", "margin-top: 4px; margin-left: 4px"), d.innerHTML = '<img src="resources/images/left_arrow.svg" width="10" height="10">\n            <span style="margin-left: 2px">\n                        RETURN\n                    </span>', l.insertBefore(d, l.firstChild), $(".tool-content-title")[0].innerText = "Download", $(".page-description")[1].innerText = "\nThe edit has been successfully completed! Click on the button below to download your file."
}
$("document").ready(function() {
    const t = $(".menu");
    let n;
    $(".hamburger").click(function() {
        t.show()
    }), $("*").click(function(e) {
        $(".menu a").is(e.target) || $(".hamburger").is(e.target) || t.hide()
    }), $("#file-upload").change(function() {
        $("#upload-btn").hide(), $(".table-container").css("display", "block"), $(".tool-nav-container").css("display", "block"), $(".tool-content-title")[0].innerText = "Upload",$('#file-upload').css("z-index", -1);$('.instruction-text').css('display', 'none');
        $('.upload-icon').css('display', 'none');
            //$(".page-description")[1].innerText = 'Review the files! You can delete or add new files to the list. If is everything all right, just click the "next" button below the\nlist to go to the translation page.',
            createTable(), updateTable()
    }), $("tbody").on("click", ".delete", function(e) {
        const t = e.target.innerText,
            n = formData.getAll("files[]");
        for (n.splice(t, 1), formData = new FormData, l = 0; l < n.length; l++) formData.append("files[]", n[l]);
        updateTable()
    }), $("#delete-all").click(function() {
        formData = new FormData, hideAllErrors(), updateTable()
    }), $(".add-btn").click(function() {
        document.getElementById("add-file").click()
    }), $("#add-file").change(function() {
        addFile(), updateTable(), $("#upload-form").trigger("reset")
    }), $("#return-button").click(function() {
        // $("#upload-btn").show(), $(".table-container").css("display", "none"), $(".tool-nav-container").css("display", "none"), $(".tool-content-title")[0].innerText = "Let's Translate!",$('#file-upload').css("z-index", -1);$('.instruction-text').css('display', 'none');
        // $('.upload-icon').css('display', 'none');
        //     //$(".page-description")[1].innerText = "To get started, click on the button below to upload your files.",
        //     $("#upload-form").trigger("reset"), $(".error-container").html(""), $("#files_info_size").css("color", "#616161"), $("#files_info_amount").css("color", "#616161")
    }),
    //     $("#next-button").click(function() {
    //     document.getElementById("pop-up-background").style.display = "block", document.getElementById("pop-up-loading").style.display = "block", $.ajax({
    //         url: "upload_file.php",
    //         data: formData,
    //         processData: !1,
    //         contentType: !1,
    //         type: "POST",
    //         success: function(e) {
    //             e = JSON.parse(e);
    //             document.getElementById("pop-up-background").style.display = "none";
    //             document.getElementById("pop-up-loading").style.display = "none";
    //             if (e.status === 'success'){
    //                 window.location.href = "translate.php?id=" + e.id;
    //             }else{
    //                 console.log('failed');
    //                 document.getElementById('pop-up-error').style.display = 'block';
    //             }
    //
    //         },
    //         // error: function() {
    //         //     document.getElementById("pop-up-background").style.display = "none", document.getElementById("pop-up-loading").style.display = "none", alert("There are one or more errors!")
    //         // }
    //     })
    // }),

    $("#translate-button").click(function() {
        if (e = document.getElementsByClassName("goog-te-combo")[0], "" == e.value)
            alert("Please, Select Language");
        else {
            setTimeout(function() {
                document.getElementById("pop-up-background").style.display = "block",
                document.getElementById("pop-up-loading").style.display = "block"
            }, 100), setTimeout(function() {
                putSubtitlesToTranslate(subtitles = getOriginalText())
            }, 500);
            let e = 0;
            $("#time-to-wait").text();
            let t = !0;
            const n = new MutationObserver(function() {
                if (e = 0, t) {
                    t = !1;
                    let e = setInterval(function() {
                        "FONT" === document.getElementById("text-to-translate").lastChild.lastChild.tagName &&
                        isTranslated() && (clearInterval(e),
                        document.getElementById("pop-up-loading").style.display = "none",
                        $(".dialog").show(), n.disconnect())
                    }, 1e3)
                }
            });
            n.observe(document.getElementById("text-to-translate"), {
                subtree: !0,
                childList: !0
            })
        }
    }), $("#dialog-acceptt").click(function() {
        document.getElementById("pop-up-background").style.display = "none", $("#form-files").attr("action", "edit.php"), $("#form-files").attr("target", "_self"), $(".dialog").hide(), document.getElementById("pop-up-background").style.display = "block", document.getElementById("pop-up-loading").style.display = "block", document.getElementsByClassName("pop-up-loading-title")[0].innerHTML = "Loading...", document.getElementsByClassName("pop-up-loading-description")[0].innerHTML = "It may take a while. Please wait.", setTimeout(function() {
            saveToEdit(subtitles), $("#form-files").submit()
        }, 1e3)
    }), $("#dialog-cancel").click(function() {
        $(".dialog").hide(),
        document.getElementById("pop-up-background").style.display = "none",
        saveTranslatedText(subtitles)
    }), $(".tool-content").on("click", "#download-button", function() {
        $(".pop-up-download").show(), $(".pop-up-background").show()
    }), $("#pop-up-download-btn-close").click(function() {
        $(".pop-up-download").hide(), $(".pop-up-background").hide()
    }),
        // $("#download-btn").click(function() {
        // $("#form-files").length ? $("#form-files").submit() : $("#upload-form").submit(), $(".pop-up-download").hide(), $(".pop-up-background").hide(), $(".tool-content-title")[0].innerText = "Downloading...", $(".page-description")[1].innerText = "Your Download should start in a few seconds!", $("#button-container #download-button").css("display", "none");
        // let e = document.createElement("button");
        // e.setAttribute("class", "red-button"), e.setAttribute("id", "new_translation_btn"),
        // e.setAttribute("data-toggle", "nodal"),
        // e.setAttribute("type", "button"),
        // e.setAttribute("data-target", "#exampleModal"),
        // e.style.height = "42px",
        // e.style.paddingTop = "0",
        // e.innerText = "SAVE TO DATABASE",
        // document.getElementById("button-container").appendChild(e), deleteAll()

    // }),
    $(".tool-content").on("click", "#new_translation_btnt", function() {
        document.location.href = "/"
    }), $(".tool-content").on("click", "#return-button-translate", function() {
        window.location.href = "/"
    }), $("#file-upload-converter").change(function() {
        let e = $("#file-upload-converter").val(),
            t = e.split(".").pop();
        n = !1, ["srt", "vtt", "stl", "sbv", "sub", "ass"].includes(t) && (n = !0), e = e.replace(/C:\\fakepath\\/i, "").replace(/\.[^/.]+$/, "").replace(/[^a-zA-Z0-9 ]/g, " "), $("#converter-uploaded-file").text(e), $("#converter-uploaded-file").show(), "" != $("#format-select").val() && "" != $("#file-upload-converter").val() && n ? $("#download-btn-converter").prop("disabled", !1) : $("#download-btn-converter").prop("disabled", !0)
    }), $("#format-select").change(function() {
        "" != $("#format-select").val() && "" != $("#file-upload-converter").val() && n ? $("#download-btn-converter").prop("disabled", !1) : $("#download-btn-converter").prop("disabled", !0)
    }), $("#download-btn-converterl").click(function() {
        (formData = new FormData).append("files[]", $("#file-upload-converter").prop("files")[0]), $.ajax({
            url: "src/services/upload_file.php",
            data: formData,
            processData: !1,
            contentType: !1,
            type: "POST",
            success: function(e) {
                window.location.href = "converter.php?format=" + $("#format-select").val() + "&id=" + e
            },
            error: function() {
                alert("There are one or more errors!")
            }
        })
    }), $("#file-upload-edit").change(function() {
        uploadToEdit()
    });
    let o = !0;
    $("#text-to-edit").ready(function() {
        $("#text-to-edit").length && document.getElementById("text-to-edit").children.length > 0 && (o && (subtitles = getTextToEdit(), o = !1), $(".tool-content-title").text("Edit"), $(".page-description").text("Select the file you want to edit from the drop down menu. When you are done editing a file, click the SAVE button to save your changes.\nWhen you have finished editing all files, click NEXT to access the download."), $("#upload-btn").hide(), $(".table-container").show(), $(".tool-nav-container").show(), generateSelectToEdit())
    }), $("#edit-file-select").change(function() {
        let e = $("#edit-file-select").val();
        "" != e && (document.getElementById("pop-up-background").style.display = "block", document.getElementById("pop-up-loading").style.display = "block", setTimeout(function() {
            $("tbody").html("");
            for (let t = 0; t < subtitles[e].length; t++) $("tbody").append("<tr>\n                        <td>" + t + '</td>\n                        <td contenteditable="true">' + window.Subtitle.toSrtTime(subtitles[e][t].start) + '</td>\n                        <td contenteditable="true">' + window.Subtitle.toSrtTime(subtitles[e][t].end) + '</td>\n                        <td contenteditable="true">' + subtitles[e][t].text + "</td>\n                    </tr>");
            document.getElementById("pop-up-background").style.display = "none", document.getElementById("pop-up-loading").style.display = "none"
        }, 500))
    }), $("#save-button").click(function() {
        let e = $("#edit-file-select").val();
        "" != e ? (document.getElementById("pop-up-background").style.display = "block", document.getElementById("pop-up-loading").style.display = "block", setTimeout(function() {
            let t = $("tbody").children();
            for (let n = 0; n < subtitles[e].length; n++) {
                let o = t[n];
                subtitles[e][n].start = o.children[1].innerText, subtitles[e][n].end = o.children[2].innerText, subtitles[e][n].text = o.children[3].innerText, document.getElementById("pop-up-background").style.display = "none", document.getElementById("pop-up-loading").style.display = "none"
            }
        }, 1e3)) : alert("Select a file first!")
    }), $("#next-button-edit").click(function() {
        document.getElementById("pop-up-background").style.display = "block", document.getElementById("pop-up-loading").style.display = "block", setTimeout(function() {
            putSubtitlesToTranslate(subtitles), saveEditedText(), document.getElementById("pop-up-background").style.display = "none", document.getElementById("pop-up-loading").style.display = "none"
        }, 1e3)
    }), $("#return-button-edit").click(function() {
        document.location.href = "/edit.php"
    });
    var l, i = $(".accordion");
    for (l = 0; l < i.length; l++) i[l].addEventListener("click", function() {
        this.classList.toggle("active"), this.classList.contains("active") ? this.children[0].style.backgroundImage = 'url("resources/images/arrow_up.svg")' : this.children[0].style.backgroundImage = 'url("resources/images/arrow_down.svg")';
        var e = this.nextElementSibling;
        "block" === e.style.display ? e.style.display = "none" : e.style.display = "block"
    })
});
