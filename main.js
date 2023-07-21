
import { apiConfig } from './env.js';
const { googleApiConfig, bitlyApiConfig } = apiConfig;
const googleApiKey = googleApiConfig.API_KEY;
const cxId = googleApiConfig.CX_ID;

const panel = document.querySelector(".comic-pane__1");
const comicImage = document.querySelector(".comic-image");
const downloadButton = document.querySelector("#download-button");

const keywords1 = ['キャプテン', '東京', 'グラゼニ', 'SPY', 'チェンソー', 'マン', '左', '嘘', '弁護士', '忘却', '巨人', '宇宙', '耕作', '花嫁', 'スナック', 'GIANT', '明日'];
const keywords2 = ['クソ', 'あいさつ', 'かわいい', '名言', 'すごい', '偉い', 'ダメ', '仕事', 'ヨシ', '口', 'クビ'];

function searchRandomKeywords() {
    const query = `${getRandomKeyword(keywords1)} AND ${getRandomKeyword(keywords2)}`;
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

    updateText = document.createElement("p");
    updateText.classList.add("update-text");
    updateText.textContent = "検索中";
    countdown = 5;
    countdownText = document.createElement("span");
    countdownText.classList.add("countdown-text");
    countdownText.textContent = ` ${countdown}`;
    updateText.appendChild(countdownText);
    panel.appendChild(updateText);

    const intervalId = setInterval(() => {
        countdown--;
        if (countdown === 0) {
        clearInterval(intervalId);
        searchRandomKeywords();
        } else {
        countdownText.textContent = ` ${countdown}`;
        }
    }, 1000);

    fetch(searchUrl)
        .then(response => response.json())
        .then(data => {
        clearInterval(intervalId);
        updateText.remove();
        countdownText.remove();

        if (data.items && data.items.length > 0) {
            const imageUrl = data.items[Math.floor(Math.random() * data.items.length)].link;
            comicImage.src = imageUrl;
        } else {
            console.error("No image found for query:", query);
            updateText.textContent = "検索中";
            countdown = 5;
            countdownText.textContent = ` ${countdown}`;
            const intervalId = setInterval(() => {
            countdown--;
            if (countdown === 0) {
                clearInterval(intervalId);
                searchRandomKeywords();
            } else {
                countdownText.textContent = ` ${countdown}`;
            }
            }, 1000);
            panel.appendChild(updateText);
            panel.appendChild(countdownText);
        }
        })
        .catch(error => {
        console.error("Error fetching search results:", error);
        updateText.textContent = "検索中";
        countdown = 5;
        countdownText.textContent = ` ${countdown}`;
        const intervalId = setInterval(() => {
            countdown--;
            if (countdown === 0) {
            clearInterval(intervalId);
            searchRandomKeywords();
            } else {
            countdownText.textContent = ` ${countdown}`;
            }
        }, 1000);
        panel.appendChild(updateText);
        panel.appendChild(countdownText);
    });
}

function getRandomKeyword(keywords) {
    return keywords[Math.floor(Math.random() * keywords.length)];
}

if (panel) {
    searchRandomKeywords();
}

function addRandomQueryParam(url) {
    const randomParam = `random=${Math.random()}`;
    return url.includes('?') ? `${url}&${randomParam}` : `${url}?${randomParam}`;
}
