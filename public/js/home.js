const welcomeTitle = document.querySelectorAll(".welcomeMsg");

welcomeTitle.forEach(title =>
    setTimeout(() => {
        title.setAttribute("hidden", null);
    }, 6000)
)
