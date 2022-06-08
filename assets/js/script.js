let currentPlaylist = [];
let shufflePlaylist = [];
let tempPlaylist = [];
let audioElement;
let mouseDown = false;
let currentIndex = 0;
let repeat = false;
let shuffle = false;
var userLoggedIn;
var timer;

$(document).click(function (click) {
    let target = $(click.target);
    if (!target.hasClass("item") && !target.hasClass("optionsButton")) {
        hideOptionsMenu();
    }
});

$(window).scroll(function () {
    hideOptionsMenu();
});

$(document).on("change", "select.playlist", function () {
    let playlistId = $(this).val();
    let songId = $(this).prev(".songId").val();

    console.log("playlist " + playlistId);
    console.log("song " + songId);

});

function openPage(url) {
    if (timer != null) {
        clearTimeout(timer);
    }

    if (url.indexOf("?") == -1) {
        url = url + "?";
    }

    let encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    $("#mainContent").load(encodedUrl);
    $("body").scrollTop(0);
    history.pushState(null, null, url);
}

function createPlaylist() {
    console.log(userLoggedIn);
    var popup = prompt("Please enter the name of your playlist");

    if (popup != null) {
        $.post("includes/handlers/ajax/createPlaylist.php", {
            name: popup,
            username: userLoggedIn,
        }).done(function (error) {
            if (error != "") {
                alert(error);
                return;
            }

            //do something when ajax returns
            openPage("yourMusic.php");
        });
    }
}

function deletePlaylist(playlistId) {
    var confirmDelete = confirm(
        "Are you sure you want to delete this playlist?"
    );
    if (confirmDelete) {
        $.post("includes/handlers/ajax/deletePlaylist.php", {
            playlistId: playlistId,
        }).done(function (error) {
            if (error != "") {
                alert(error);
                return;
            }

            //do something when ajax returns
            openPage("yourMusic.php");
        });
    }
}

function hideOptionsMenu() {
    let menu = $(".optionsMenu");
    if (menu.css("display") != "none") {
        menu.css("display", "none");
    }
}

function showOptionsMenu(button) {
    let songId = $(button).prevAll(".songId").val();
    let menu = $(".optionsMenu");
    let menuWidth = menu.width();
    menu.find(".songId").val(songId);

    let scrollTop = $(window).scrollTop();
    let elementOffset = $(button).offset().top;
    let top = elementOffset - scrollTop;
    let left = $(button).position().left;
    menu.css({
        top: top + "px",
        left: left - menuWidth + "px",
        display: "inline",
    });
}

function formatTime(timeInMs) {
    let time = Math.round(timeInMs);
    let minutes = Math.floor(time / 60);
    let seconds = time - minutes * 60;

    let extraZero;

    if (seconds < 10) {
        extraZero = "0";
    } else {
        extraZero = "";
    }

    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(
        formatTime(audio.duration - audio.currentTime)
    );

    let progress = (audio.currentTime / audio.duration) * 100;

    $(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
    let progress = audio.volume * 100;

    $(".volumeBar .progress").css("width", progress + "%");
}

function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio() {
    this.currentlyPlaying;
    this.audio = document.createElement("audio");

    this.audio.addEventListener("ended", function () {
        nextSong();
    });

    this.audio.addEventListener("canplay", function () {
        let duration = formatTime(this.duration);

        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("timeupdate", function () {
        if (this.duration) {
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function () {
        updateVolumeProgressBar(this);
    });

    this.setTrack = function (track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    };

    this.play = function () {
        this.audio.play();
    };

    this.pause = function () {
        this.audio.pause();
    };

    this.setTime = function (seconds) {
        this.audio.currentTime = seconds;
    };
}
