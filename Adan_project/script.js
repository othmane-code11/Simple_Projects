let prayertimes = {};
let adan = new Audio("adan.mp3");

function updateclock() {
    let d = new Date();
    let options = {
        year : "numeric",
        month : "long",
        day : "numeric"
    };

    document.getElementById("date").textContent = d.toLocaleDateString("en-GB", options);
    let hours = String(d.getHours()).padStart(2, "0");
    let minutes = String(d.getMinutes()).padStart(2, "0");
    let seconds = String(d.getSeconds()).padStart(2, "0");

    document.getElementById("clock").textContent = `${hours}:${minutes}:${seconds}`;

    if (Object.keys(prayertimes).length > 0) {
        let curr = `${hours}:${minutes}`;
        if (Object.values(prayertimes).includes(curr)) {
            adan.play();
        }
    }
};

async function gadlk() {
    let respo = await fetch("prayer_times.php");
    prayertimes = await respo.json();

    document.getElementById("fajr_time").textContent = prayertimes.Fajr;
    document.getElementById("sunrise_time").textContent = prayertimes["Sunrise"];
    document.getElementById("dhuhr_time").textContent = prayertimes["Dhuhr"];
    document.getElementById("sunrise_time").textContent = prayertimes["Sunrise"];
    document.getElementById("asr_time").textContent = prayertimes["Asr"];
    document.getElementById("maghrib_time").textContent = prayertimes["Maghrib"];
    document.getElementById("isha_time").textContent = prayertimes["Isha"];
};
setInterval(updateclock, 1000);
gadlk();