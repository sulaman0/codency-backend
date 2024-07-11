<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<style>
    p {
        letter-spacing: 1px;
    }
</style>
<center><h1>Amplifier Logs!</h1></center>
<hr>
<div class="output-logs"></div>
<script>
    const userEmail = '{{ $userEmail }}';
    let audioQueue = [];
    let isPlaying = false;

    // Function to get the current date and time as a formatted string
    function getCurrentDateTime() {
        const now = new Date();
        const options = {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false // Use 24-hour format
        };
        return now.toLocaleString('en-US', options).replace(',', '');
    }

    // Function to check if 24 hours have passed since the last reset
    function checkAndResetLog() {
        const lastReset = localStorage.getItem('lastReset');
        const now = new Date().getTime();

        if (lastReset) {
            const elapsed = now - parseInt(lastReset, 10);
            // 24 hours in milliseconds
            const twentyFourHours = 24 * 60 * 60 * 1000;

            if (elapsed >= twentyFourHours) {
                // Clear the log and update reset time
                document.querySelector('.output-logs').innerHTML = '';
                localStorage.setItem('lastReset', now);
            }
        } else {
            // If no reset record exists, set it for the first time
            localStorage.setItem('lastReset', now);
        }
    }

    // Function to write message with current date and time
    function writeMessage(words) {
        // Find the element with class 'output-logs'
        const outputLogs = document.querySelector('.output-logs');
        if (outputLogs) {
            // Get current date and time
            const dateTime = getCurrentDateTime();
            // Prepend the message with date and time
            outputLogs.insertAdjacentHTML('afterbegin', `<p>[${dateTime}] == ${words}</p>`);
        }
    }

    // Function to perform a fetch request with custom headers
    async function fetchUnPlayedAlert() {
        writeMessage("========================================================");
        writeMessage("Fetching Alerts from live server");
        const url = 'un-played-alert'; // Replace with your actual route URL
        const headers = new Headers({
            'Content-Type': 'application/json',
            'header-x-unique': userEmail,
        });
        return fetch(url, {
            method: 'GET',
            headers: headers
        }).then(response => {
            if (!response.ok) {
                writeMessage(`<b><h2>ERROR!</h2></b>` + 'Network response was not ok ' + response.statusText);
                return;
            }
            return response.json();
        }).then(data => {
            if (data && data.status) {
                writeMessage(`Total ${data.payload.length} Alert(s) to be Played!`);
                writeMessage(`Payload ${JSON.stringify(data)}`)
                data.payload.forEach(alert => {
                    audioQueue.push({audioUrl: alert.tune, times: alert.times, name: alert.name});
                    markAlertHasPlayed(alert.id, alert.name);
                });
                playAudioFromQueue();
            } else if (data) {
                writeMessage(`<b><h2>ERROR!</h2></b>:` + JSON.stringify(data));
            }
        }).catch(error => {
            writeMessage(`<b><h2>ERROR!</h2></b>: ${error.message}`);
        });
    }

    // Function to play audio files sequentially with specified repeat counts
    function playAudioSequentially(payload) {
        let index = 0;

        function playNextAudio() {
            if (index >= payload.length) {
                writeMessage("All alerts have been played.");
                return;
            }

            const {tune: audioUrl, no_of_play: times} = payload[index];

            let playCount = 0;

            function playCurrentAudio() {
                if (playCount >= times) {
                    index++;
                    playNextAudio(); // Move to the next audio file
                    return;
                }

                const audio = new Audio(audioUrl);
                audio.addEventListener('ended', () => {
                    playCount++;
                    playCurrentAudio(); // Play the same audio file again if needed
                });

                audio.play().catch(error => {
                    writeMessage('Error playing audio: ' + error.message);
                });
            }

            // Start playing the current audio file
            playCurrentAudio();
        }

        // Start playing the first audio file
        playNextAudio();
    }

    // Function to play audio files sequentially
    function playAudioFromQueue() {
        console.log(audioQueue, "audio queue");
        if (audioQueue.length === 0 || isPlaying) {
            return; // Exit if there's nothing to play or an audio is already playing
        }

        isPlaying = true;
        const {audioUrl, times, name} = audioQueue.shift(); // Get the next audio file from the queue
        let playCount = 0;

        function playCurrentAudio() {
            writeMessage(`Playing alert ${name} Time: ${playCount}`);
            if (playCount >= times) {
                isPlaying = false;
                playAudioFromQueue(); // Play the next audio file if any
                return;
            }

            const audio = new Audio(audioUrl);
            audio.addEventListener('ended', () => {
                playCount++;
                playCurrentAudio(); // Play the same audio file again if needed
            });
            audio.play().catch(error => {
                console.error('Error playing audio: ' + error.message);
                isPlaying = false;
                playAudioFromQueue(); // Play the next audio file if there's an error
            });
        }

        // Start playing the current audio file
        playCurrentAudio();
    }

    function markAlertHasPlayed(id, name) {
        const url = `mark-alert-played/${id}`;
        const headers = new Headers({
            'Content-Type': 'application/json',
            'header-x-unique': userEmail,
        });
        return fetch(url, {
            method: 'GET',
            headers: headers
        }).then(response => {
            if (!response.ok) {
                writeMessage(`<b><h2>ERROR!</h2></b>` + 'Network response was not ok When Marking Alert is played ' + response.statusText);
                return;
            }
            return response.json();
        }).then(data => {
            if (data && data.status) {
                writeMessage(`${id} ${name}  Alert is Played to Server Sent`);
            } else if (data) {
                writeMessage(`<b><h2>ERROR!</h2></b>:` + JSON.stringify(data));
            }
        }).catch(error => {
            writeMessage(`<b><h2>ERROR!</h2></b>: ${error.message}`);
        });
    }

    // Initial check and reset
    checkAndResetLog();

    // Set up the interval to call writeMessage and fetchUnPlayedAlert every 10 seconds
    setInterval(async function () {
        checkAndResetLog();
        await fetchUnPlayedAlert();
    }, 1000);
</script>
</body>
</html>
