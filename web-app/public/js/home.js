document.addEventListener("DOMContentLoaded", function () {
    const openModalBtn = document.getElementById("openPostModal");
    const closeModalBtn = document.getElementById("closePostModal");
    const postModal = document.getElementById("postModal");

    openModalBtn.addEventListener("click", function () {
        postModal.style.display = "block";
    });

    closeModalBtn.addEventListener("click", function () {
        postModal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target == postModal) {
            postModal.style.display = "none";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const profileMenu = document.querySelector(".profile-menu");
    const dropdown = document.querySelector(".dropdown-content");

    profileMenu.addEventListener("click", function (e) {
        e.stopPropagation();
        dropdown.style.display =
            dropdown.style.display === "block" ? "none" : "block";
    });

    document.addEventListener("click", function (e) {
        if (!profileMenu.contains(e.target)) {
            dropdown.style.display = "none";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-users");
    const suggestionsBox = document.getElementById("search-suggestions");

    if (searchInput && suggestionsBox) {
        searchInput.addEventListener("input", function () {
            const query = searchInput.value.trim();

            if (query.length === 0) {
                suggestionsBox.innerHTML = "";
                suggestionsBox.classList.remove("active");
                return;
            }

            fetch(`/search-users?query=${encodeURIComponent(query)}`)
                .then((response) => response.json())
                .then((users) => {
                    suggestionsBox.innerHTML = "";
                    if (users.length > 0) {
                        users.forEach((user) => {
                            const div = document.createElement("div");
                            div.textContent = `${user.name} (@${user.username})`;
                            div.addEventListener("click", function () {
                                window.location.href = `/profile/${user.id}`;
                            });
                            suggestionsBox.appendChild(div);
                        });
                        suggestionsBox.classList.add("active");
                    } else {
                        suggestionsBox.classList.remove("active");
                    }
                });
        });

        document.addEventListener("click", function (e) {
            if (
                !searchInput.contains(e.target) &&
                !suggestionsBox.contains(e.target)
            ) {
                suggestionsBox.classList.remove("active");
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".comment-input textarea").forEach((textarea) => {
        textarea.addEventListener("keydown", function (event) {
            if (event.key === "Enter" && !event.shiftKey) {
                event.preventDefault();
                this.closest("form").submit();
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const weatherOpenBtn = document.getElementById("weather-open-btn");
    const weatherModal = document.getElementById("weatherModal");
    const weatherCloseBtn = document.getElementById("weather-close-btn");

    if (weatherOpenBtn && weatherModal && weatherCloseBtn) {
        weatherOpenBtn.addEventListener("click", () => {
            weatherModal.style.display = "block";
        });

        weatherCloseBtn.addEventListener("click", () => {
            weatherModal.style.display = "none";
        });

        window.addEventListener("click", (event) => {
            if (event.target === weatherModal) {
                weatherModal.style.display = "none";
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const weatherSearchBtn = document.getElementById("weather-search-btn");
    const weatherCityInput = document.getElementById("weather-city");
    const weatherResultDiv = document.getElementById("weather-result");

    if (weatherSearchBtn && weatherCityInput && weatherResultDiv) {
        weatherSearchBtn.addEventListener("click", () => {
            WeatherSearch();
        });

        weatherCityInput.addEventListener("keydown", function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
                WeatherSearch();
            }
        });

        function WeatherSearch() {
            const city = weatherCityInput.value.trim();
            if (!city) {
                alert("Inserisci una località!");
                return;
            }

            fetch(`/weather?city=${encodeURIComponent(city)}`)
                .then((res) => res.json())
                .then((data) => {
                    if (data.cod === 200) {
                        showWeatherData(data);
                    } else {
                        weatherResultDiv.innerHTML = `<p style="color:red;">Località non trovata.</p>`;
                    }
                })
                .catch((error) => {
                    console.error("Errore chiamata meteo:", error);
                    weatherResultDiv.innerHTML = `<p style="color:red;">Errore di rete.</p>`;
                });
        }

        function showWeatherData(data) {
            const cityName = data.name;
            const temp = data.main.temp.toFixed(1);
            const desc = data.weather[0].description;
            const icon = data.weather[0].icon;

            weatherResultDiv.innerHTML = `
                <h3>${cityName}</h3>
                <p><img src="https://openweathermap.org/img/wn/${icon}@2x.png" alt="${desc}"></p>
                <p><strong>Temperatura:</strong> ${temp} °C</p>
                <p><strong>Descrizione:</strong> ${desc}</p>
            `;
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const spotifyOpenBtn = document.getElementById("spotify-open-btn");
    const spotifyModal = document.getElementById("spotifyModal");
    const spotifyCloseBtn = document.getElementById("spotify-close-btn");
    const spotifyQueryInput = document.getElementById("spotify-query");
    const spotifySearchBtn = document.getElementById("spotify-search-btn");
    const spotifyResults = document.getElementById("spotify-results");

    if (spotifyOpenBtn && spotifyModal) {
        spotifyOpenBtn.addEventListener("click", () => {
            spotifyModal.style.display = "block";
        });
    }

    if (spotifyCloseBtn && spotifyModal) {
        spotifyCloseBtn.addEventListener("click", () => {
            spotifyModal.style.display = "none";
        });
        window.addEventListener("click", (event) => {
            if (event.target === spotifyModal) {
                spotifyModal.style.display = "none";
            }
        });
    }

    if (spotifySearchBtn && spotifyQueryInput && spotifyResults) {
        spotifySearchBtn.addEventListener("click", async () => {
            const query = spotifyQueryInput.value.trim();
            if (!query) {
                alert("Inserisci un brano o un artista!");
                return;
            }
            const data = await SpotifySearch(query);
            showSpotifyTracks(data);
        });
    }

    async function SpotifySearch(query) {
        const url = `/spotify/search?q=${encodeURIComponent(query)}`;
        const resp = await fetch(url);
        return await resp.json();
    }

    function showSpotifyTracks(data) {
        if (!data.tracks || !data.tracks.items?.length) {
            spotifyResults.innerHTML = "<p>Nessun risultato trovato</p>";
            return;
        }
        let html = "<ul>";
        data.tracks.items.forEach((item) => {
            const trackName = item.name;
            const artistName = item.artists[0].name;
            const albumCover = item.album.images[2]?.url || "";
            html += `
                <li style="margin:10px 0;">
                    <img src="${albumCover}" alt="cover" style="vertical-align:middle;width:40px;height:40px;margin-right:10px;">
                    <strong>${trackName}</strong> - ${artistName}
                </li>
            `;
        });
        html += "</ul>";
        spotifyResults.innerHTML = html;
    }
});
