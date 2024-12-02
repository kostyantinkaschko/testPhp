let buttonPreviousText = 0,
    passwordCheck = false,
    passwordChecker = false

function showBlock(block, buttonId, buttonText, declaration = ".", animation = false) {
    let blockDom = document.querySelector(declaration + block),
        buttonOpenDom = document.querySelector("#" + buttonId)

    if (buttonPreviousText == 0) {
        buttonPreviousText = buttonOpenDom.innerHTML
    }
    blockDom.classList.toggle("hide")
    if (blockDom.classList.contains("hide")) {
        buttonOpenDom.innerHTML = buttonPreviousText
        buttonOpenDom.setAttribute("data-open", "false")
    } else {
        buttonOpenDom.innerHTML = buttonText
        buttonOpenDom.setAttribute("data-open", "true")
        // blockDom.classList.add("slideFromBottom")
    }
}