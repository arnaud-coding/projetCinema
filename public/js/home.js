const welcomeTitle = document.querySelectorAll("h1");
console.log(" welcomeTitle:", welcomeTitle)

welcomeTitle.forEach(title =>
    setTimeout(() => {
        title.setAttribute("hidden", null);
    }, 6000)
)
