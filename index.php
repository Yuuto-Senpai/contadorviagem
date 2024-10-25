<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contagem Regressiva para a Viagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
 

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
        body {
            background: linear-gradient(75.5deg, #43CBAD, #8f94fb, #00c6ff, #391471, #4D74A8);
            background-size: 300% 300%;
            animation: gradient 20s ease infinite;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            color: #fff;
            margin: 0;
            overflow: hidden;
            position: relative;
            padding: 0 20px;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .content {
            display: flex;
            gap: 30px;
            align-items: flex-start;
            justify-content: center;
            z-index: 1;
        }
        .countdown-container {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            text-align: center;
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: fadeIn 1.5s ease-in-out;
            flex-shrink: 0;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .countdown-timer {
            font-size: 2.5rem;
            color: #FFFF00;
            font-weight: bold;
            text-shadow: 0 0 10px #ffcc00, 0 0 20px #ffcc00, 0 0 30px #ffcc00;
        }
        .btn-logout {
            background: linear-gradient(75.4deg, #5a67d8, #ff758c);
            background-size: 200% 200%;
            animation: gradient-btn 3s ease infinite;
            color: #fff;
            border-radius: 30px;
            padding: 12px 24px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            font-weight: 600;
        }
        @keyframes gradient-btn {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .btn-logout:hover {
            background-color: #434190;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }
        #calendar {
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
            max-width: 700px;
            width: 100%;
            z-index: 2;
            position: relative;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        .fc-day-today {
            background-color: rgba(255, 255, 255, 0.2) !important;
            border-radius: 8px;
            color: #fff !important;
        }
        .fc-event {
            background-color: #ff9f89 !important;
            color: #fff !important;
            border-radius: 5px;
            padding: 5px;
            font-weight: 500;
        }
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <div class="content">
        <div class="countdown-container">
            <h1><i class="fas fa-plane-departure"></i> Contagem Regressiva para a Viagem</h1>
            <p id="countdown" class="countdown-timer">Carregando...</p>
            <a href="logout.php" class="btn-logout mt-3">Sair</a>
        </div>

        <div id="calendar"></div>
    </div>

    <script>
        async function getViagemData() {
            try {
                const response = await fetch('viagem.php');
                if (!response.ok) {
                    throw new Error('Erro ao buscar os dados da viagem.');
                }
                const data = await response.json();
                const dataViagem = new Date(`${data.data_viagem}T11:25:00`);
                return dataViagem;
            } catch (error) {
                console.error('Erro:', error);p
                document.getElementById('countdown').innerHTML = "<span style='color: red;'>Erro ao carregar a data da viagem.</span>";
                throw error;
            }
        }

        function startCountdown(targetDate) {
            function updateCountdown() {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance < 0) {
                    document.getElementById('countdown').innerHTML = "<span style='color: green;'>A viagem começou!</span>";
                    clearInterval(interval);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('countdown').innerHTML =
                    `${days.toString().padStart(2, '0')}d ${hours.toString().padStart(2, '0')}h ` +
                    `${minutes.toString().padStart(2, '0')}m ${seconds.toString().padStart(2, '0')}s`;
            }

            const interval = setInterval(updateCountdown, 1000);
            updateCountdown();
        }

        getViagemData()
            .then(startCountdown)
            .catch(error => console.log("A contagem regressiva não pôde ser iniciada.", error));

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                events: [
                    {
                        title: 'Dia da Viagem',
                        start: '2024-11-01',
                        display: 'background',
                        backgroundColor: '#ff9f89'
                    }
                ]
            });
            calendar.render();

            // Animações de entrada com GSAP
            gsap.from(".countdown-container", { duration: 1.5, y: -50, opacity: 0, ease: "power2.out" });
            gsap.from("#calendar", { duration: 1.5, x: 50, opacity: 0, ease: "power2.out", delay: 0.5 });
        });

        particlesJS('particles-js', {
            particles: {
                number: { value: 150, density: { enable: true, value_area: 800 } },
                color: { value: ["#ffffff", "#ffcc00", "#ff758c"] },
                shape: { type: ["circle", "star", "triangle", "polygon"] },
                opacity: { value: 0.5, random: true },
                size: { value: 4.5, random: true }
            },
            interactivity: {
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    onclick: { enable: true, mode: "push" }
                },
                modes: {
                    repulse: { distance: 200 },
                    push: { particles_nb: 4 }
                }
            },
            retina_detect: true
        });
    </script>
</body>
</html>
