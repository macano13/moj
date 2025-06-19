document.getElementById('searchButton').addEventListener('click', searchSubtitles);

async function searchSubtitles() {
    const query = document.getElementById('subtitleSearch').value;
    const lang = document.getElementById('languageSelect').value;

    try {
        // Adjust API call to include /search prefix
        const response = await axios.get(`/search/api/subtitles?query=${query}&lang=${lang}`);
        const subtitles = response.data.subtitles;
        const resultsDiv = document.getElementById('results');
        resultsDiv.innerHTML = ''; // Clear previous results

        subtitles.forEach(subtitle => {
            const subtitleElement = document.createElement('div');
            subtitleElement.innerHTML = `
                <p>${subtitle.name}</p>
                <a href="/search/api/subtitles/download/${subtitle.id}" target="_blank" class="download-btn">Download</a>
            `;
            resultsDiv.appendChild(subtitleElement);
        });

    } catch (error) {
        console.error('Error fetching subtitles', error);
    }
}

