// searchUserText.js

import { apiConfig } from './env.js';
const { googleApiConfig, bitlyApiConfig } = apiConfig;
const googleApiKey = googleApiConfig.API_KEY;
const cxId = googleApiConfig.CX_ID;

const panel = document.querySelector(".comic-pane__1");
const comicImage = document.querySelector(".comic-image");

let isIMEComposing = false; // IMEの変換中かどうか
let isSearching = false; // 検索実行中かどうか

// エンターキーで検索を実行するイベントリスナー
const searchInput = document.getElementById('search-input');

// IMEの変換中かどうかを判定するためのイベントリスナー
searchInput.addEventListener('compositionstart', function() {
  isIMEComposing = true;
});

searchInput.addEventListener('compositionend', function() {
  isIMEComposing = false;
});

searchInput.addEventListener('keyup', function(event) {
  if (event.key === 'Enter') {
    if (!isIMEComposing) {
      // IMEの変換が確定していない場合は検索を実行
      searchButtonHandler();
    } else {
      // IMEの変換が確定している場合は何もしない（検索を待つ）
    }
  }
});

// 検索ボタンのクリックイベントハンドラを定義
function searchButtonHandler() {
  if (isSearching) {
    // 既に検索実行中の場合、新たな検索を無視
    return;
  }

  const searchInput = document.getElementById('search-input');
  const query = searchInput.value.trim(); // 入力されたテキストを取得し、両端の空白を削除
  if (query !== '') {
      performSearch(query);
  }
}

// 画像をクリア
function clearImage() {
  comicImage.src = '';
}

// 検索を実行する関数
function performSearch(query) {
  // 検索実行中フラグをtrueに設定
  isSearching = true;

  const encodedQuery = encodeURIComponent(query);
  const searchUrl = `https://www.googleapis.com/customsearch/v1?key=${googleApiKey}&cx=${cxId}&searchType=image&q=${encodedQuery}`;

  // 前回の検索結果をクリア
  panel.innerHTML = '';

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
              panel.appendChild(comicImage); // 画像を表示
          } else {
              console.error("No image found for query:", query);
              updateText.textContent = "見つかりませんでした";
              panel.appendChild(updateText);
          }

          // 検索完了時に検索実行中フラグをfalseに設定
          isSearching = false;

          })
          .catch(error => {
          console.error("Error fetching search results:", error);
          updateText.textContent = "検索エラー";
          panel.appendChild(updateText);

          // 検索エラー時に検索実行中フラグをfalseに設定
          isSearching = false;
          });
      } else {
      countdownText.textContent = ` ${countdown}`;
      }
  }, 1000);
}

// 検索ボタンのクリックイベントリスナーを追加
const searchButton = document.getElementById('search-button');
searchButton.addEventListener('click', searchButtonHandler);