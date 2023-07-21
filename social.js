// social.js

// 画像のダウンロード
function downloadImage(imageSrc) {
  return new Promise((resolve, reject) => {
    const link = document.createElement('a');
    link.href = imageSrc;
    link.download = `todays1frame.${getExtensionFromUrl(imageSrc)}`;
    link.target = '_blank';

    link.addEventListener('click', () => {
      setTimeout(() => {
        URL.revokeObjectURL(link.href);
      }, 1000);
    });

    link.dispatchEvent(
      new MouseEvent('click', {
        bubbles: true,
        cancelable: true,
        view: window,
      })
    );

    resolve();
  });
}

// URLから拡張子を取得
function getExtensionFromUrl(url) {
  const path = url.split('/').pop();
  const filename = path.split('?')[0];
  return filename.split('.').pop();
}

// シェアボタンをクリックしたときの処理
function shareOnTwitter(event) {
  event.preventDefault();

  const comicImage = document.querySelector('.comic-image');
  const imageUrl = comicImage.src;

  // Twitterの共有URLを生成
  const twitterURL = `https://twitter.com/intent/tweet?url=${encodeURIComponent(imageUrl)}`;

  // ツイートボタンをクリックしたときの処理
  window.open(twitterURL, 'Share on Twitter', 'width=550,height=350');
}

// ダウンロードボタンのクリックイベントハンドラを定義
function downloadButtonHandler() {
  const imageUrlWithQueryParam = addRandomQueryParam(comicImage.src);
  downloadImage(imageUrlWithQueryParam)
    .then(() => {
      console.log('Download complete');
      // ダウンロード完了後にイベントリスナーを削除
      downloadButton.removeEventListener('click', downloadButtonHandler);
    })
    .catch((error) => {
      console.log(`Download failed. ${error}`);
    });
}

// HTML要素のロードが完了したらイベントリスナーを追加
document.addEventListener('DOMContentLoaded', function () {
  const shareButton = document.getElementById('share-button');
  const downloadButton = document.getElementById('download-button');

  if (shareButton) {
    shareButton.onclick = shareOnTwitter;
  }

  if (downloadButton) {
    downloadButton.removeEventListener('click', downloadButtonHandler);
    downloadButton.addEventListener('click', downloadButtonHandler);
  }
});