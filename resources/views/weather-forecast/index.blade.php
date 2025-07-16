@extends('layouts.sidebar_final')

@section('content')
<style>
    :root {
        --yi-primary: #1a2235;
        --yi-accent: #FFB51B;
        --yi-accent-dark: #e6a318;
        --yi-bg: #1a2235;
        --yi-card-bg: #fff;
        --yi-card-border: #FFB51B;
        --yi-shadow: 0 4px 24px 0 rgba(26,34,53,0.10), 0 1.5px 4px 0 rgba(26,34,53,0.04);
        --yi-radius: 1.25rem;
        --yi-text: #1a2235;
        --yi-muted: #64748b;
        --yi-success: #22c55e;
        --yi-danger: #ef4444;
    }
    .yi-bg {
        background: var(--yi-bg);
        min-height: 100vh;
        padding: 2rem 0;
    }
    .yi-card {
        background: var(--yi-card-bg);
        border-radius: var(--yi-radius);
        box-shadow: var(--yi-shadow);
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1.5px solid var(--yi-card-border);
    }
    .yi-title {
        color: #fff;
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .yi-section-title {
        color: var(--yi-accent);
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .yi-label {
        color: var(--yi-primary);
        font-weight: 600;
    }
    .yi-input {
        border: 2px solid var(--yi-accent);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        outline: none;
        transition: border 0.2s;
        background: #fff;
        color: var(--yi-text);
    }
    .yi-input:focus {
        border-color: var(--yi-primary);
        box-shadow: 0 0 0 2px var(--yi-accent-dark);
    }
    .yi-btn {
        background: var(--yi-primary);
        color: #fff;
        font-weight: 700;
        border: none;
        border-radius: 0.75rem;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px 0 rgba(26,34,53,0.10);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        outline: none;
    }
    .yi-btn .bx {
        color: var(--yi-accent);
        font-size: 1.25em;
    }
    .yi-btn:hover, .yi-btn:focus {
        background: var(--yi-accent);
        color: var(--yi-primary);
    }
    .yi-btn:hover .bx, .yi-btn:focus .bx {
        color: var(--yi-primary);
    }
    .yi-btn[disabled], .yi-btn:disabled {
        background: #f1f5f9;
        color: #b0b0b0;
        cursor: not-allowed;
    }
    .yi-card-header {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--yi-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .yi-advisory {
        background: #fff;
        border-left: 6px solid var(--yi-accent);
        border-radius: 0.75rem;
        padding: 1rem 1.5rem;
        font-size: 1.1rem;
        color: var(--yi-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 2px 8px 0 rgba(26,34,53,0.06);
    }
    .yi-pinned {
        background: #f8fafc;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 1px 4px 0 rgba(26,34,53,0.04);
    }
    .yi-pinned .yi-btn {
        padding: 0.5rem 1rem;
        font-size: 0.95rem;
    }
    .yi-guide-list li {
        margin-bottom: 0.5rem;
    }
    .yi-weather-icon {
        width: 2.5rem;
        height: 2.5rem;
        margin-right: 0.5rem;
    }
    .yi-temp {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--yi-accent);
        margin-bottom: 0.25rem;
    }
    .yi-weather-label {
        font-size: 1.1rem;
        color: var(--yi-muted);
        margin-bottom: 0.5rem;
    }
    .yi-forecast-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 8px 0 rgba(26,34,53,0.06);
        padding: 1rem;
        text-align: center;
        margin-bottom: 1rem;
    }
    .yi-forecast-card .yi-weather-icon {
        margin: 0 auto 0.5rem auto;
    }
    .yi-scroll-x {
        overflow-x: auto;
        display: flex;
        gap: 1rem;
        padding-bottom: 1rem;
    }
    .yi-scroll-x > * {
        flex: 0 0 auto;
    }
    @media (max-width: 768px) {
        .yi-title { font-size: 1.5rem; }
        .yi-card { padding: 1rem; }
    }
</style>
<div class="yi-bg">
    <div class="container mx-auto max-w-4xl">
        <div class="yi-title text-center mb-8">
            <i class='bx bx-leaf text-4xl' style="color:var(--yi-accent)"></i> Weather App
        </div>
        <div class="yi-card yi-shadow">
            <div class="yi-section-title"><i class='bx bx-search'></i> Check the Weather</div>
            <form id="weatherForm" class="flex flex-col md:flex-row gap-3 mb-2">
                <input type="text" id="cityInput" class="yi-input flex-grow" placeholder="Enter a city (e.g. Manila)">
                <input type="text" id="provinceInput" class="yi-input flex-grow" placeholder="Enter a Province (optional)">
                <button type="submit" class="yi-btn"><i class='bx bx-search'></i> Search</button>
                <button id="locationBtn" type="button" class="yi-btn"><i class='bx bx-current-location'></i> Use My Location</button>
            </form>
            <div class="text-xs text-gray-500 mt-1">Tip: Enter your city and province for the most accurate results.</div>
        </div>

        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div class="yi-card yi-shadow" id="weatherResults"></div>
            <div class="yi-card yi-shadow" id="weatherResults2"></div>
        </div>

        <div class="yi-advisory" id="advisory">
            <i class='bx bx-info-circle text-2xl' style="color:var(--yi-accent)"></i>
            <span class="font-semibold">Farming Advisory:</span>
            <span class="font-medium">Select location to view advisories</span>
        </div>

        <div class="yi-section-title mt-8"><i class='bx bx-calendar'></i> 7-Day Forecast</div>
        <div class="grid grid-cols-2 md:grid-cols-6 gap-3" id="weeklyForecast"></div>

        <div class="yi-section-title mt-8"><i class='bx bx-time-five'></i> Hourly Forecast</div>
        <div class="yi-scroll-x" id="hourlyForecast"></div>

        <div class="yi-card yi-shadow mt-8 max-w-md mx-auto">
            <div class="yi-card-header"><i class="bx bx-pin"></i> Pinned Locations</div>
            <div id="pinnedLocations" class="mt-2"></div>
        </div>

        <div class="yi-card yi-shadow mt-8">
            <div class="yi-section-title"><i class='bx bx-book'></i> Weather Terminology Guide</div>
            <div class="mt-4">
                <div class="yi-label mb-1">📌 Atmospheric Pressure (hPa)</div>
                <ul class="yi-guide-list text-sm text-gray-700">
                    <li><strong>🔻 Below 1000 hPa:</strong> Low pressure → Rain or storms are likely.</li>
                    <li><strong>🔺 Above 1015 hPa:</strong> High pressure → Clear and dry weather.</li>
                </ul>
            </div>
            <div class="mt-4">
                <div class="yi-label mb-1">💧 Humidity (%)</div>
                <ul class="yi-guide-list text-sm text-gray-700">
                    <li><strong>🌿 Below 40%:</strong> Dry air, plants lose moisture quickly.</li>
                    <li><strong>🌧️ Above 80%:</strong> High risk of mold, fungus, and plant diseases.</li>
                </ul>
            </div>
            <div class="mt-4">
                <div class="yi-label mb-1">🌦️ Precipitation (mm)</div>
                <ul class="yi-guide-list text-sm text-gray-700">
                    <li><strong>0 mm:</strong> No rain expected.</li>
                    <li><strong>1-5 mm:</strong> Light rain, may slightly wet the ground.</li>
                    <li><strong>10-20 mm:</strong> Moderate rain, noticeable wet conditions.</li>
                    <li><strong>20+ mm:</strong> Heavy rain, possible flooding risks.</li>
                </ul>
            </div>
            <div class="mt-4">
                <div class="yi-label mb-1">🌧️ Rain Chance (%)</div>
                <ul class="yi-guide-list text-sm text-gray-700">
                    <li><strong>0-20%:</strong> Very unlikely to rain.</li>
                    <li><strong>30-50%:</strong> Possible scattered showers.</li>
                    <li><strong>60-80%:</strong> Likely to rain, bring an umbrella! ☂️</li>
                    <li><strong>90-100%:</strong> Almost certain rain or storms expected.</li>
                </ul>
            </div>
            <div class="mt-4">
                <div class="yi-label mb-1">📊 Rain Chance vs. Precipitation</div>
                <ul class="yi-guide-list text-sm text-gray-700">
                    <li>✔ <strong>Precipitation (mm)</strong> → How much rain will fall.</li>
                    <li>✔ <strong>Rain Chance (%)</strong> → How likely it is to rain.</li>
                </ul>
                <div class="text-xs text-gray-500 mt-2">Examples:</div>
                <ul class="yi-guide-list text-sm text-gray-700">
                    <li>🌥️ <strong>20% Rain Chance & 0 mm Precipitation</strong> → Clouds present, but very low chance of rain.</li>
                    <li>🌦️ <strong>80% Rain Chance & 5 mm Precipitation</strong> → High chance of light rain.</li>
                    <li>⛈️ <strong>90% Rain Chance & 30 mm Precipitation</strong> → Very likely and heavy rain expected!</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
        const API_KEY = "{{ $OPEN_WEATHERMAP_KEY1 }}";
        const form = document.getElementById("weatherForm");
        const cityInput = document.getElementById("cityInput");
        const provinceInput = document.getElementById("provinceInput");
        const weatherResults = document.getElementById("weatherResults");
        const weatherResults2 = document.getElementById("weatherResults2");
        const hourlyForecast = document.getElementById("hourlyForecast");
        const weeklyForecast = document.getElementById("weeklyForecast");
        const advisory = document.getElementById("advisory");
        const locationBtn = document.getElementById("locationBtn");
        const USE_ONE_CALL_API = true;

        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const city = cityInput.value.trim();
            const province = provinceInput.value.trim();
            
            if (city) {
                getWeather(city, province);
            }
        });


        locationBtn.addEventListener("click", () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => getWeatherByCoords(position.coords.latitude, position.coords.longitude),
                    () => alert("Location access denied")
                );
            }
        });

        function getWeather(city, province = "") {
            let query = `${city},PH`;
            if (province.trim()) {
                query = `${city},${province},PH`;  
            }

            fetch(`https://api.openweathermap.org/geo/1.0/direct?q=${query}&limit=5&appid=${API_KEY}`)
                .then(res => res.json())
                .then(locations => {
                    if (locations.length === 0) {
                        weatherResults.innerHTML = "<p class='text-red-500'>Location not found. Try again.</p>";
                        return;
                    }

                    const location = locations[0];
                    getWeatherByCoords(location.lat, location.lon);
                })
                .catch(() => weatherResults.innerHTML = "<p class='text-red-500'>Error fetching location data</p>");
        }


        function getWeatherByCoords(lat, lon) {
            fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${API_KEY}&units=metric`)
                .then(res => res.json())
                .then(data => {
                    displayWeather(data);
                    displayWeather2(data);
                    displayAdvisory(data);

                    // Pin
                    weatherResults.innerHTML += `
                        <button onclick="pinLocation('${data.name}', ${lat}, ${lon})"
                            class="mt-3 px-4 py-2 rounded-lg 
                                ${isPinned(lat, lon) ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700'} 
                                text-white flex items-center space-x-2"
                            ${isPinned(lat, lon) ? 'disabled' : ''}>
                            <i class="bx ${isPinned(lat, lon) ? 'bx-check-circle' : 'bx-pin'} text-lg"></i>
                            <span>
                                ${isPinned(lat, lon) ? "✅ Already Pinned" : "📌 Pin Location"}
                            </span>
                        </button>

                    `;
                });
        }

        function displayWeather(data) {
            const currentTime = new Date();
            const formattedTime = currentTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const formattedDate = currentTime.toLocaleDateString('en-US', options);

            const weatherInfo = getFriendlyWeatherDescription(data.weather[0].description);

            weatherResults.innerHTML = `
                <h2 class="text-xl font-bold text-gray-800">${data.name}, ${data.sys.country}</h2>
                
                <!-- Display weather image and text -->
                <div class="flex items-center space-x-2">
                    <img src="${weatherInfo.image}" alt="${weatherInfo.text}" class="w-16 h-16">
                    <p class="text-lg text-gray-600 capitalize">${weatherInfo.text}</p>
                </div>

                <p class="text-2xl font-bold text-blue-500">${data.main.temp}°C</p> 
                <p class="text-sm text-gray-500">Updated as of ${formattedTime}</p>
                <p class="text-sm text-gray-600 font-medium mt-2">${formattedDate}</p>
            `;

            getWeeklyForecast(data.coord.lat, data.coord.lon);
            displayHourlyForecast(data.coord.lat, data.coord.lon);
        }


        function displayWeather2(data) {
            const currentTime = new Date();
            const formattedTime = currentTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const formattedDate = currentTime.toLocaleDateString('en-US', options);
            const sunrise = new Date(data.sys.sunrise * 1000).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const sunset = new Date(data.sys.sunset * 1000).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            const precipitation = data.rain ? (data.rain["1h"] || 0) : 0;

            fetch(`https://api.openweathermap.org/data/2.5/forecast?lat=${data.coord.lat}&lon=${data.coord.lon}&appid=${API_KEY}&units=metric`)
                .then(res => res.json())
                .then(forecastData => {
                    const rainChance = forecastData.list[0].pop ? (forecastData.list[0].pop * 100).toFixed(0) : "0";

                    weatherResults2.innerHTML = `
                        <div class="mt-2 text-gray-700">
                            <div class="flex">
                                <div>
                                    <p><i class='bx bx-thermometer'></i> Feels like: ${data.main.feels_like.toFixed(2)}°C</p>
                                    <p><i class='bx bx-water'></i> Humidity: ${data.main.humidity}%</p> 
                                    <p><i class='bx bx-bar-chart-alt-2'></i> Pressure: ${data.main.pressure} mb</p>
                                    <p><i class='bx bx-wind'></i> Wind: ${(data.wind.speed * 3.6).toFixed(2)} Km/H</p>
                                    <p><i class='bx bx-cloud-rain'></i> Precipitation: ${precipitation} mm</p>
                                    <p><i class='bx bx-droplet'></i> Rain Chance: ${rainChance}%</p>
                                </div>
    
                                <div>
                                    <div class="flex items-center mt-2">
                                        <img src="images/Additional/sunrise.png" alt="Sunrise" class="w-8 h-8 mr-2">
                                        <p class="text-gray-700 font-medium">Sunrise: ${sunrise}</p>
                                    </div>
        
                                    <div class="flex items-center mt-2">
                                        <img src="images/Additional/sunset.png" alt="Sunset" class="w-8 h-8 mr-2">
                                        <p class="text-gray-700 font-medium">Sunset: ${sunset}</p>
                                    </div>
                                </div>
                            </divc>
                        </div>
                    `;
                });
        }

        function displayAdvisory(data) {
            const temp = data.main.temp;
            const wind = data.wind.speed;
            const weather = data.weather[0].main.toLowerCase();
            let message = "";

            if (weather.includes("rain")) {
                message = "🌧️ High rainfall expected - postpone outdoor activities.";
            } else if (temp > 35) {
                message = "🔥 Extreme heat warning - protect crops and livestock.";
            } else if (wind > 10) {
                message = "💨 High winds - secure equipment and structures.";
            } else {
                message = "🌾 Favorable conditions for farming activities.";
            }

            advisory.innerHTML = message;
        }

        // function getWeeklyForecast(lat, lon) {
        //     fetch(`https://api.openweathermap.org/data/2.5/forecast?lat=${lat}&lon=${lon}&appid=${API_KEY}&units=metric`)
        //         .then(res => res.json())
        //         .then(data => {
        //             weeklyForecast.innerHTML = "";

        //             const daily = {};
        //             data.list.forEach(entry => {
        //                 let date = entry.dt_txt.split(" ")[0];
        //                 if (!daily[date]) {
        //                     const weatherInfo = getFriendlyWeatherDescription(entry.weather[0].description);
                            
        //                     daily[date] = {
        //                         minTemp: entry.main.temp_min,
        //                         maxTemp: entry.main.temp_max,
        //                         weather: weatherInfo.text,
        //                         icon: weatherInfo.image,
        //                         rainChance: entry.pop ? (entry.pop * 100).toFixed(0) : "0",
        //                         fullDate: new Date(entry.dt_txt),
        //                     };
        //                 } else {
        //                     daily[date].minTemp = Math.min(daily[date].minTemp, entry.main.temp_min);
        //                     daily[date].maxTemp = Math.max(daily[date].maxTemp, entry.main.temp_max);
        //                 }
        //             });

        //             const forecastArray = Object.values(daily).slice(0, 7);

        //             forecastArray.forEach(day => {
        //                 const options = { weekday: 'short', month: 'short', day: 'numeric' };
        //                 const formattedDate = day.fullDate.toLocaleDateString('en-US', options);

        //                 weeklyForecast.innerHTML += `
        //                     <div class="bg-white/90 p-4 rounded-xl shadow-lg flex flex-col items-center text-center">
        //                         <p class="text-sm font-semibold">${formattedDate}</p>
        //                         <img src="${day.icon}" alt="${day.weather}" class="w-20 h-20">
        //                         <p class="text-sm text-gray-700">${day.weather}</p>
        //                         <p class="text-sm font-medium text-blue-500 flex items-center space-x-2">
        //                             <span class="text-red-500 font-bold">${day.maxTemp.toFixed(1)}°C</span> 
        //                             <span class="text-gray-500">/</span> 
        //                             <span class="text-blue-500 font-bold">${day.minTemp.toFixed(1)}°C</span>
        //                         </p>
        //                         <p class="text-sm text-gray-700 font-medium">🌧️ ${day.rainChance}% Rain</p>
        //                     </div>
        //                 `;
        //                 //  <p class="text-lg font-bold text-blue-500">${day.maxTemp.toFixed(1)}°C / ${day.minTemp.toFixed(1)}°C</p>
        //             });
        //         });
        // }

        function displayHourlyForecast(lat, lon) {
    fetch(`https://api.openweathermap.org/data/2.5/forecast?lat=${lat}&lon=${lon}&appid=${API_KEY}&units=metric`)
        .then(res => res.json())
        .then(data => {
            hourlyForecast.innerHTML = ""; // Clear previous results

            const currentDate = new Date().toISOString().split("T")[0]; 
            const todayForecast = data.list.filter(entry => entry.dt_txt.startsWith(currentDate)); // Filter only today's forecast
            // const todayForecast = data.list.filter(entry => new Date(entry.dt * 1000) > now); // Only future times

            todayForecast.forEach(hour => {
                const time = new Date(hour.dt * 1000).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit", hour12: true });
                const temp = hour.main.temp.toFixed(1);
                const weatherIcon = `https://openweathermap.org/img/wn/${hour.weather[0].icon}.png`;
                const rainChance = hour.pop ? (hour.pop * 100).toFixed(0) : "0"; // Probability of precipitation in %

                hourlyForecast.innerHTML += `
                    <div class="flex flex-col items-center p-2 bg-white/90 rounded-lg shadow-md">
                        <p class="text-sm font-semibold">${time}</p>
                        <img src="${weatherIcon}" alt="${hour.weather[0].description}" class="w-10 h-10">
                        <p class="text-sm text-gray-700">${hour.weather[0].description}</p>
                        <p class="text-sm font-bold text-blue-500">${temp}°C</p>
                        <p class="text-sm text-gray-700">🌧️ ${rainChance}% Rain</p>
                    </div>
                `;
            });
        })
        .catch(error => console.error("Error fetching hourly forecast:", error));
}


        function getWeeklyForecast(lat, lon) {
    fetch(`https://api.openweathermap.org/data/2.5/forecast?lat=${lat}&lon=${lon}&appid=${API_KEY}&units=metric`)
        .then(res => res.json())
        .then(data => {
            weeklyForecast.innerHTML = "";

            const daily = {};
            data.list.forEach(entry => {
                let date = entry.dt_txt.split(" ")[0];
                if (!daily[date]) {
                    const weatherInfo = getFriendlyWeatherDescription(entry.weather[0].description);
                    
                    let rainChance = entry.pop ? (entry.pop * 100).toFixed(0) : "0";
                    if (rainChance < 1) {
                        rainChance = "0";  // Show as 0% if below 1% chance
                    }

                    let precipitation = entry.rain ? entry.rain['3h'] : 0;
                    
                    daily[date] = {
                        minTemp: entry.main.temp_min,
                        maxTemp: entry.main.temp_max,
                        weather: weatherInfo.text,
                        icon: weatherInfo.image,
                        rainChance: rainChance,
                        precipitation: precipitation, 
                        fullDate: new Date(entry.dt_txt),
                    };
                } else {
                    daily[date].minTemp = Math.min(daily[date].minTemp, entry.main.temp_min);
                    daily[date].maxTemp = Math.max(daily[date].maxTemp, entry.main.temp_max);
                    
                    if (entry.pop > daily[date].rainChance) {
                        daily[date].rainChance = entry.pop;
                    }
                    
                    // Accumulate precipitation (in mm)
                    if (entry.rain && entry.rain['3h']) {
                        daily[date].precipitation += entry.rain['3h'];
                    }
                }
            });

            const forecastArray = Object.values(daily).slice(0, 7);

            forecastArray.forEach(day => {
                const options = { weekday: 'short', month: 'short', day: 'numeric' };
                const formattedDate = day.fullDate.toLocaleDateString('en-US', options);

                weeklyForecast.innerHTML += `
                    <div class="bg-white/90 p-4 rounded-xl shadow-lg flex flex-col items-center text-center">
                        <p class="text-sm font-semibold">${formattedDate}</p>
                        <img src="${day.icon}" alt="${day.weather}" class="w-20 h-20">
                        <p class="text-sm text-gray-700">${day.weather}</p>
                        <p class="text-sm font-medium text-blue-500 flex items-center space-x-2">
                            <span class="text-red-500 font-bold">${day.maxTemp.toFixed(1)}°C</span> 
                            <span class="text-gray-500">/</span> 
                            <span class="text-blue-500 font-bold">${day.minTemp.toFixed(1)}°C</span>
                        </p>
                        <p class="text-sm text-gray-700 font-medium">🌧️ ${day.rainChance}% Rain</p>
                        <p class="text-sm text-gray-700 font-medium">💧 ${day.precipitation.toFixed(1)} mm Precipitation</p>
                    </div>
                `;
            });
        });
}



        function getFriendlyWeatherDescription(description) {
            const weatherMapping = {
                "clear sky": { text: "Clear Sky", image: "images/v1/sunny.png" },
                "few clouds": { text: "Mostly Sunny", image: "images/v1/sunny_s_cloudy.png" },
                "scattered clouds": { text: "Partly Cloudy", image: "images/v1/partly_cloudy.png" },
                "broken clouds": { text: "Cloudy", image: "images/v1/cloudy_s_sunny.png" },
                "overcast clouds": { text: "Overcast", image: "images/v1/cloudy.png" },
                "light rain": { text: "Light Rain", image: "images/v1/rain_light.png" },
                "moderate rain": { text: "Moderate Rain", image: "images/v1/rain.png" },
                "heavy intensity rain": { text: "Heavy Rain", image: "images/v1/rain_heavy.png" },
                "thunderstorm": { text: "⚡ Thunderstorm", image: "images/v1/thunderstorms.png" },
                // "mist": { text: "Misty", image: "images/v1/fog.png" },
                // "haze": { text: "Hazy", image: "images/v1/fog.png" },
                // "fog": { text: "Foggy", image: "images/v1/fog.png" },
                // "snow": { text: "Snow", image: "images/v1/snow.png" },
                // "drizzle": { text: "Light Drizzle", image: "images/v1/rain_light.png" },
                // "rain and snow": { text: "Rain and Snow", image: "images/v1/rain_s_snow.png" },
                // "rain showers": { text: "Rain Showers", image: "images/v1/rain_s_cloudy.png" },
                // "snow showers": { text: "Snow Showers", image: "images/v1/snow_s_cloudy.png" },
                // "heavy snow": { text: "Heavy Snow", image: "images/v1/snow_heavy.png" },
                // "light snow": { text: "Light Snow", image: "images/v1/snow_light.png" },
                "sunny with rain": { text: "Sunny with Rain", image: "images/v1/sunny_s_rain.png" },
                "sunny with clouds": { text: "unny with Clouds", image: "images/v1/sunny_s_cloudy.png" },
            };

            return weatherMapping[description.toLowerCase()] || { text: description, image: "images/v1/default.png" };
        }










    // Pin Location

    const pinLimit = 3;
    const pinnedLocations = JSON.parse(localStorage.getItem("pinnedLocations")) || [];
    const pinnedLocationsDiv = document.getElementById("pinnedLocations");

    // Check if location is already pinned
    function isPinned(lat, lon) {
        return pinnedLocations.some(loc => loc.lat === lat && loc.lon === lon);
    }

    // save pinned locations to localStorage
    function savePinnedLocations() {
        localStorage.setItem("pinnedLocations", JSON.stringify(pinnedLocations));
        displayPinnedLocations();
    }

    // add a location to pinned
    function pinLocation(name, lat, lon) {
        if (pinnedLocations.length >= pinLimit) {
            alert("You have reached the maximum number of pinned locations.");
            return;
        }

        if (isPinned(lat, lon)) {
            alert("Location is already pinned!");
            return;
        }

        pinnedLocations.push({ name, lat, lon });
        savePinnedLocations();
    }

    // remove a pinned location 
    function removePinnedLocation(lat, lon) {
        const index = pinnedLocations.findIndex(loc => loc.lat === lat && loc.lon === lon);
        if (index !== -1) {
            pinnedLocations.splice(index, 1);
            savePinnedLocations();
        }
    }

    // display pinned locations
    function displayPinnedLocations() {
        pinnedLocationsDiv.innerHTML = "";

        if (pinnedLocations.length === 0) {
            pinnedLocationsDiv.innerHTML = "<p class='text-gray-600'>No locations pinned yet.</p>";
            return;
        }

        pinnedLocations.forEach(loc => {
            const locationDiv = document.createElement("div");
            locationDiv.classList.add("bg-green-100", "p-3", "rounded-lg", "flex", "justify-between", "items-center");

            locationDiv.innerHTML = `
                <p class="text-lg font-semibold text-gray-800">${loc.name}</p>
<div class="space-x-4 flex items-center">
    <!-- View Forecast Button with Icon -->
    <button 
        onclick="getWeatherByCoords(${loc.lat}, ${loc.lon})" 
        class="btn btn-primary bg-blue-500 text-white hover:bg-blue-600 flex items-center space-x-2 px-4 py-2 rounded-lg transition-all duration-200">
        <i class="bx bx-calendar text-xl"></i>
        <span>View Forecast</span>
    </button>

    <!-- Remove Button with Icon -->
    <button 
        onclick="removePinnedLocation(${loc.lat}, ${loc.lon})" 
        class="btn btn-danger bg-red-500 text-white hover:bg-red-600 flex items-center space-x-2 px-4 py-2 rounded-lg transition-all duration-200">
        <i class="bx bx-trash text-xl"></i>
        <span>Remove</span>
    </button>
</div>

            `;

            pinnedLocationsDiv.appendChild(locationDiv);
        }); 
    }

    document.addEventListener("DOMContentLoaded", displayPinnedLocations);
    </script>
@endsection
