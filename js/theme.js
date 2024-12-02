document.addEventListener("DOMContentLoaded", () => {
    let toggleButton = document.getElementById("themeToggle"),
        currentTheme = localStorage.getItem("theme")

    if (currentTheme === "dark") {
        document.body.classList.add("dark-mode")
    }

    toggleButton.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode")
        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark")
        } else {
            localStorage.setItem("theme", "light")
        }
    })
})
