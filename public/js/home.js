const welcomeMsg = document.querySelectorAll(".welcomeMsg");

welcomeMsg.forEach(msg => {
    setTimeout(() => {
        msg.setAttribute("hidden", true);
    }, 3000)
})