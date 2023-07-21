// performSearch.js

import { apiConfig } from './env.js';
const { googleApiConfig } = apiConfig;
const { API_KEY, CX_ID } = googleApiConfig;

const panel = document.querySelector(".comic-pane__1");
const comicImage = document.querySelector(".comic-image");
const downloadButton = document.querySelector("#download-button");

function performSearch(query) {
    const searchUrl = `https://www.googleapis.com/customsearch/v1?key=${googleApiKey}&cx=${cxId}&searchType=image&q=${encodeURIComponent(query)}`;

    let updateText = document.querySelector(".update-text");
    let countdownText = document.querySelector(".countdown-text");
    let countdown;

    if (updateText) {
        updateText.remove();
    }
    if (countdownText) {
        countdownText.remove();
    }

    updateText = document.createElement("div");
    updateText.classList.add("update-text");
    updateText.textContent = "検索中";
    countdown = 5;
    countdownText = document.createElement("span");
    countdownText.classList.add("countdown-text");
    countdownText.textContent = ` ${countdown}`;
    updateText.appendChild(countdownText);
    updateText.style.display = "flex";
    updateText.style.alignItems = "center";
    updateText.style.justifyContent = "center";
    panel.innerHTML = "";
    panel.appendChild(updateText);

    const intervalId = setInterval(() => {
        countdown--;
        if (countdown === 0) {
        clearInterval(intervalId);
        fetch(searchUrl)
            .then(response => response.json())
            .then(data => {
            updateText.remove();
            countdownText.remove();

            if (data.items && data.items.length > 0) {
                const imageUrl = data.items[Math.floor(Math.random() * data.items.length)].link;
                const comicImage = document.createElement("img");
                comicImage.classList.add("comic-image");
                comicImage.src = imageUrl;
                panel.appendChild(comicImage); // 画像を表示する
            } else {
                console.error("No image found for query:", query);
                updateText.textContent = "見つかりませんでした";
                panel.appendChild(updateText);
            }
            })
            .catch(error => {
            console.error("Error fetching search results:", error);
            updateText.textContent = "検索エラー";
            panel.appendChild(updateText);
            });
        } else {
        countdownText.textContent = ` ${countdown}`;
        }
    }, 1000);
}

export default performSearch;