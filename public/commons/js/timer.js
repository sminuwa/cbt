function startTimer(duration, display) {
    let timer = duration, hours, minutes, seconds;
    const interval = setInterval(() => {
        hours = parseInt(timer / 3600, 10);
        minutes = parseInt((timer % 3600) / 60, 10);
        seconds = parseInt(timer % 60, 10);

        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = hours + ":" + minutes + ":" + seconds;

        // Change color to red when 15 minutes (900 seconds) are left
        if (timer <= 900) {
            display.style.color = 'red';
        }

        if (--timer < 0) {
            clearInterval(interval);
            alert("Time's up!");
        }
    }, 1000);
}

window.onload = function () {
    const twoHours = 60 * 60 * 2; // 2 hours in seconds
    const display = document.querySelector('#clock');
    startTimer(twoHours, display);
};
