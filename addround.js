function checkBack(week) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText == 'back') {
                setBack();
            } else if(this.responseText == 'front') {
                setFront();
            }
        }
    };
    xmlhttp.open("GET", "isback.php?week=" + week, true);
    xmlhttp.send();
    console.log(week);
}

function setBack() {
    document.getElementById("hole1").innerHTML = "Hole 10:";
    document.getElementById("hole2").innerHTML = "Hole 11:";
    document.getElementById("hole3").innerHTML = "Hole 12:";
    document.getElementById("hole4").innerHTML = "Hole 13:";
    document.getElementById("hole5").innerHTML = "Hole 14:";
    document.getElementById("hole6").innerHTML = "Hole 15:";
    document.getElementById("hole7").innerHTML = "Hole 16:";
    document.getElementById("hole8").innerHTML = "Hole 17:";
    document.getElementById("hole9").innerHTML = "Hole 18:";
}

function setFront() {
    document.getElementById("hole1").innerHTML = "Hole 1:";
    document.getElementById("hole2").innerHTML = "Hole 2:";
    document.getElementById("hole3").innerHTML = "Hole 3:";
    document.getElementById("hole4").innerHTML = "Hole 4:";
    document.getElementById("hole5").innerHTML = "Hole 5:";
    document.getElementById("hole6").innerHTML = "Hole 6:";
    document.getElementById("hole7").innerHTML = "Hole 7:";
    document.getElementById("hole8").innerHTML = "Hole 8:";
    document.getElementById("hole9").innerHTML = "Hole 9:";
}