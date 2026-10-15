<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Weather Information</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
            transition: background 1.5s ease;
            background: #0a0a0f;
        }

        /* ============================================================
           WEATHER BACKGROUNDS - DAY / NIGHT
           ============================================================ */

        /* ☀️ SUNNY DAY */
        body.weather-clear.is-day {
            background: linear-gradient(180deg, #1e3a5f 0%, #2d5a8c 40%, #4a7fb5 70%, #6ba3d6 100%);
        }

        /* 🌙 SUNNY NIGHT */
        body.weather-clear.is-night {
            background: linear-gradient(180deg, #0a0a1a 0%, #0f0f2a 40%, #151535 70%, #1a1a45 100%);
        }

        /* ☁️ CLOUDY DAY */
        body.weather-cloudy.is-day {
            background: linear-gradient(180deg, #2c3e50 0%, #3d566e 40%, #4a6b85 70%, #5a7d99 100%);
        }

        /* ☁️ CLOUDY NIGHT */
        body.weather-cloudy.is-night {
            background: linear-gradient(180deg, #0a0a14 0%, #12121e 40%, #1a1a2e 70%, #22223a 100%);
        }

        /* 🌧️ RAINY DAY */
        body.weather-rain.is-day {
            background: linear-gradient(180deg, #1a2a3a 0%, #243447 40%, #2e4258 70%, #3a5268 100%);
        }

        /* 🌧️ RAINY NIGHT */
        body.weather-rain.is-night {
            background: linear-gradient(180deg, #05080f 0%, #0a1018 40%, #101820 70%, #15202a 100%);
        }

        /* 🌫️ FOG DAY */
        body.weather-fog.is-day {
            background: linear-gradient(180deg, #3a4550 0%, #4a5560 40%, #5a6570 70%, #6a7580 100%);
        }

        /* 🌫️ FOG NIGHT */
        body.weather-fog.is-night {
            background: linear-gradient(180deg, #10151a 0%, #181e24 40%, #202830 70%, #283038 100%);
        }

        /* ⛈️ THUNDER DAY */
        body.weather-thunder.is-day {
            background: linear-gradient(180deg, #0f0f1a 0%, #15152a 40%, #1a1a3a 70%, #20204a 100%);
        }

        /* ⛈️ THUNDER NIGHT */
        body.weather-thunder.is-night {
            background: linear-gradient(180deg, #05050a 0%, #0a0a15 40%, #0f0f20 70%, #14142a 100%);
        }

        /* ❄️ SNOW DAY */
        body.weather-snow.is-day {
            background: linear-gradient(180deg, #4a5a6a 0%, #5a6a7a 40%, #6a7a8a 70%, #7a8a9a 100%);
        }

        /* ❄️ SNOW NIGHT */
        body.weather-snow.is-night {
            background: linear-gradient(180deg, #0f1520 0%, #151e2a 40%, #1a2530 70%, #202c38 100%);
        }

        /* ============================================================
           SUN (Sunny day)
           ============================================================ */
        .sun {
            position: fixed;
            top: 8%;
            right: 12%;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, #fff8e1 0%, #ffd54f 30%, #ffb300 60%, #ff8f00 100%);
            border-radius: 50%;
            box-shadow: 
                0 0 40px rgba(255, 213, 79, 0.8),
                0 0 80px rgba(255, 179, 0, 0.5),
                0 0 140px rgba(255, 143, 0, 0.3);
            z-index: 1;
            opacity: 0;
            transition: opacity 2s ease;
            animation: sunPulse 4s ease-in-out infinite;
        }

        body.weather-clear.is-day .sun {
            opacity: 1;
        }

        @keyframes sunPulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 
                    0 0 40px rgba(255, 213, 79, 0.8),
                    0 0 80px rgba(255, 179, 0, 0.5),
                    0 0 140px rgba(255, 143, 0, 0.3);
            }
            50% {
                transform: scale(1.08);
                box-shadow: 
                    0 0 60px rgba(255, 213, 79, 1),
                    0 0 110px rgba(255, 179, 0, 0.7),
                    0 0 180px rgba(255, 143, 0, 0.4);
            }
        }

        /* Sun Rays */
        .sun-rays {
            position: fixed;
            top: 8%;
            right: 12%;
            width: 100px;
            height: 100px;
            z-index: 0;
            opacity: 0;
            transition: opacity 2s ease;
            pointer-events: none;
        }

        body.weather-clear.is-day .sun-rays {
            opacity: 1;
        }

        .sun-ray {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 3px;
            height: 200px;
            background: linear-gradient(to top, transparent, rgba(255, 213, 79, 0.4), transparent);
            transform-origin: bottom center;
            transform: translate(-50%, -100%) rotate(0deg);
            animation: rayRotate 20s linear infinite;
            border-radius: 50%;
            filter: blur(2px);
        }

        @keyframes rayRotate {
            from { transform: translate(-50%, -100%) rotate(0deg); }
            to { transform: translate(-50%, -100%) rotate(360deg); }
        }

        /* ============================================================
           MOON + STARS (Sunny night)
           ============================================================ */
        .moon {
            position: fixed;
            top: 8%;
            right: 12%;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle at 35% 35%, #ffffff 0%, #e8eaf6 40%, #c5cae9 100%);
            border-radius: 50%;
            box-shadow: 
                0 0 40px rgba(200, 210, 255, 0.6),
                0 0 80px rgba(150, 170, 255, 0.3),
                inset -10px -10px 20px rgba(100, 120, 180, 0.3);
            z-index: 1;
            opacity: 0;
            transition: opacity 2s ease;
            animation: moonGlow 5s ease-in-out infinite;
        }

        body.weather-clear.is-night .moon {
            opacity: 1;
        }

        @keyframes moonGlow {
            0%, 100% {
                box-shadow: 
                    0 0 40px rgba(200, 210, 255, 0.6),
                    0 0 80px rgba(150, 170, 255, 0.3),
                    inset -10px -10px 20px rgba(100, 120, 180, 0.3);
            }
            50% {
                box-shadow: 
                    0 0 60px rgba(200, 210, 255, 0.8),
                    0 0 110px rgba(150, 170, 255, 0.5),
                    inset -10px -10px 20px rgba(100, 120, 180, 0.4);
            }
        }

        /* Stars */
        .stars-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            opacity: 0;
            transition: opacity 2s ease;
        }

        body.weather-clear.is-night .stars-container {
            opacity: 1;
        }

        .star {
            position: absolute;
            background: #ffffff;
            border-radius: 50%;
            animation: twinkle ease-in-out infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.2; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.3); }
        }

        /* ============================================================
           CLOUDS
           ============================================================ */
        .clouds-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            opacity: 0;
            transition: opacity 1.5s ease;
            overflow: hidden;
        }

        .clouds-container.active {
            opacity: 1;
        }

        .cloud {
            position: absolute;
            background: #ffffff;
            border-radius: 100px;
            filter: blur(8px);
            animation: cloudDrift linear infinite;
        }

        .cloud::before,
        .cloud::after {
            content: '';
            position: absolute;
            background: inherit;
            border-radius: 50%;
        }

        .cloud::before {
            width: 55%;
            height: 140%;
            top: -45%;
            left: 12%;
        }

        .cloud::after {
            width: 45%;
            height: 120%;
            top: -30%;
            right: 12%;
        }

        @keyframes cloudDrift {
            from {
                transform: translateX(-40vw);
            }
            to {
                transform: translateX(140vw);
            }
        }

        /* ============================================================
           RAIN
           ============================================================ */
        .rain-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
            opacity: 0;
            transition: opacity 1s ease;
            overflow: hidden;
        }

        .rain-container.active {
            opacity: 1;
        }

        .rain-drop {
            position: absolute;
            top: -10%;
            width: 2px;
            background: linear-gradient(transparent, rgba(170, 200, 255, 0.6));
            animation: rainFall linear infinite;
            border-radius: 2px;
        }

        @keyframes rainFall {
            0% {
                transform: translateY(-100vh);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh);
                opacity: 0.1;
            }
        }

        /* ============================================================
           LIGHTNING / THUNDER
           ============================================================ */
        .lightning-flash {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(200, 220, 255, 0.35);
            pointer-events: none;
            z-index: 5;
            opacity: 0;
        }

        .lightning-flash.flash {
            animation: lightningFlash 0.5s ease-out;
        }

        .lightning-flash.flash-strong {
            animation: lightningStrong 0.7s ease-out;
        }

        @keyframes lightningFlash {
            0% { opacity: 0; }
            10% { opacity: 1; }
            20% { opacity: 0.2; }
            35% { opacity: 0.9; }
            100% { opacity: 0; }
        }

        @keyframes lightningStrong {
            0% { opacity: 0; }
            8% { opacity: 1; }
            15% { opacity: 0.1; }
            28% { opacity: 1; }
            40% { opacity: 0.3; }
            55% { opacity: 0.9; }
            70% { opacity: 0.2; }
            85% { opacity: 0.7; }
            100% { opacity: 0; }
        }

        /* Lightning Bolt SVG-like */
        .lightning-bolt {
            position: fixed;
            top: 0;
            width: 6px;
            height: 55vh;
            background: linear-gradient(to bottom, 
                rgba(255, 255, 255, 1) 0%, 
                rgba(220, 235, 255, 0.9) 30%,
                rgba(200, 220, 255, 0.6) 60%,
                transparent 100%);
            pointer-events: none;
            z-index: 6;
            opacity: 0;
            filter: blur(1px);
            box-shadow: 
                0 0 20px rgba(200, 220, 255, 0.9),
                0 0 40px rgba(150, 180, 255, 0.6),
                0 0 80px rgba(100, 150, 255, 0.3);
            border-radius: 3px;
        }

        .lightning-bolt::before {
            content: '';
            position: absolute;
            top: 25%;
            left: -25px;
            width: 4px;
            height: 35%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.9), transparent);
            transform: rotate(28deg);
            filter: blur(1px);
            border-radius: 2px;
            box-shadow: 0 0 15px rgba(200, 220, 255, 0.8);
        }

        .lightning-bolt::after {
            content: '';
            position: absolute;
            top: 40%;
            right: -20px;
            width: 4px;
            height: 28%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8), transparent);
            transform: rotate(-32deg);
            filter: blur(1px);
            border-radius: 2px;
            box-shadow: 0 0 15px rgba(200, 220, 255, 0.7);
        }

        .lightning-bolt.strike {
            animation: boltStrike 0.6s ease-out;
        }

        @keyframes boltStrike {
            0% { opacity: 0; transform: scaleY(0); }
            8% { opacity: 1; transform: scaleY(1); }
            20% { opacity: 0.2; }
            35% { opacity: 1; }
            50% { opacity: 0.4; }
            65% { opacity: 0.9; }
            100% { opacity: 0; transform: scaleY(1); }
        }

        /* ============================================================
           FOG
           ============================================================ */
        .fog-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 3;
            opacity: 0;
            transition: opacity 2s ease;
            overflow: hidden;
        }

        .fog-container.active {
            opacity: 1;
        }

        .fog-layer {
            position: absolute;
            width: 200%;
            height: 60%;
            background: radial-gradient(ellipse at center, 
                rgba(220, 230, 245, 0.35) 0%, 
                rgba(220, 230, 245, 0.15) 35%, 
                transparent 70%);
            border-radius: 50%;
            filter: blur(30px);
        }

        .fog-layer:nth-child(1) {
            top: 10%;
            left: -50%;
            animation: fogMove1 18s ease-in-out infinite;
        }

        .fog-layer:nth-child(2) {
            top: 30%;
            left: -30%;
            background: radial-gradient(ellipse at center, 
                rgba(200, 215, 235, 0.3) 0%, 
                transparent 65%);
            animation: fogMove2 24s ease-in-out infinite;
        }

        .fog-layer:nth-child(3) {
            top: 50%;
            left: -60%;
            background: radial-gradient(ellipse at center, 
                rgba(210, 225, 240, 0.28) 0%, 
                transparent 60%);
            animation: fogMove3 30s ease-in-out infinite;
        }

        .fog-layer:nth-child(4) {
            top: 0%;
            left: -40%;
            background: radial-gradient(ellipse at center, 
                rgba(230, 240, 255, 0.2) 0%, 
                transparent 55%);
            animation: fogMove4 22s ease-in-out infinite;
        }

        @keyframes fogMove1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(15%, 8%) scale(1.15); }
        }

        @keyframes fogMove2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-12%, 12%) scale(1.2); }
        }

        @keyframes fogMove3 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(10%, -10%) scale(1.1); }
        }

        @keyframes fogMove4 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-8%, -6%) scale(1.08); }
        }

        /* ============================================================
           SNOW
           ============================================================ */
        .snow-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
            opacity: 0;
            transition: opacity 1.5s ease;
            overflow: hidden;
        }

        .snow-container.active {
            opacity: 1;
        }

        .snow-flake {
            position: absolute;
            top: -5%;
            color: #ffffff;
            text-shadow: 0 0 6px rgba(200, 220, 255, 0.8);
            animation: snowFall linear infinite;
            user-select: none;
        }

        @keyframes snowFall {
            0% {
                transform: translateY(-100vh) translateX(0) rotate(0deg);
                opacity: 1;
            }
            50% {
                transform: translateY(50vh) translateX(30px) rotate(180deg);
            }
            100% {
                transform: translateY(100vh) translateX(-20px) rotate(360deg);
                opacity: 0.2;
            }
        }

        /* ============================================================
           MAIN CONTAINER
           ============================================================ */
        .container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            background: rgba(10, 12, 22, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 28px;
            padding: 40px 32px 32px;
            box-shadow: 
                0 25px 60px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(255, 255, 255, 0.03) inset,
                0 0 80px rgba(0, 0, 0, 0.3);
            animation: containerFadeIn 0.8s ease-out;
        }

        @keyframes containerFadeIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 28px;
        }

        .header .icon {
            font-size: 48px;
            display: block;
            margin-bottom: 8px;
            filter: drop-shadow(0 0 20px rgba(100, 181, 246, 0.3));
            animation: floatIcon 3s ease-in-out infinite;
        }

        @keyframes floatIcon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 0.3px;
        }

        /* Search Form */
        form {
            display: flex;
            gap: 10px;
            margin: 28px 0 16px;
        }

        input {
            flex: 1;
            min-width: 0;
            padding: 16px 18px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            font-size: 15px;
            color: #ffffff;
            outline: none;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        input:focus {
            border-color: rgba(100, 181, 246, 0.5);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(100, 181, 246, 0.1);
        }

        button {
            padding: 16px 24px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            white-space: nowrap;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        button:hover {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .hint {
            color: rgba(255, 255, 255, 0.3);
            font-size: 12px;
            text-align: center;
            letter-spacing: 0.3px;
        }

        /* Error */
        .error {
            color: #fca5a5;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 14px;
            margin: 16px 0;
            text-align: center;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Weather Result */
        .weather-result {
            animation: resultFadeIn 0.8s ease-out;
        }

        @keyframes resultFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .location {
            text-align: center;
            margin: 24px 0 8px;
        }

        .location h2 {
            font-size: 22px;
            font-weight: 600;
            color: #ffffff;
            letter-spacing: -0.3px;
        }

        .location .country {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .temperature {
            font-size: 80px;
            font-weight: 800;
            color: #ffffff;
            text-align: center;
            line-height: 1;
            margin: 20px 0 8px;
            letter-spacing: -3px;
            text-shadow: 0 0 60px rgba(100, 181, 246, 0.3);
            animation: tempPulse 3s ease-in-out infinite;
        }

        @keyframes tempPulse {
            0%, 100% { text-shadow: 0 0 60px rgba(100, 181, 246, 0.3); }
            50% { text-shadow: 0 0 80px rgba(100, 181, 246, 0.5); }
        }

        .temperature .unit {
            font-size: 32px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 0;
            vertical-align: super;
        }

        .condition {
            text-align: center;
            font-size: 18px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 28px;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        /* Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin-top: 8px;
        }

        .detail-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            padding: 18px 12px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .detail-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.12);
            transform: translateY(-3px);
        }

        .detail-card .detail-icon {
            font-size: 22px;
            display: block;
            margin-bottom: 8px;
        }

        .detail-card .detail-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .detail-card .detail-value {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.3px;
        }

        .detail-card .detail-value .small-unit {
            font-size: 12px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.25);
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .container {
                padding: 28px 20px 24px;
                border-radius: 22px;
            }

            h1 {
                font-size: 24px;
            }

            .temperature {
                font-size: 64px;
                letter-spacing: -2px;
            }

            .temperature .unit {
                font-size: 26px;
            }

            form {
                flex-direction: column;
            }

            button {
                width: 100%;
                padding: 16px;
            }

            .details-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .detail-card {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 14px 18px;
                text-align: left;
            }

            .detail-card .detail-icon {
                margin-bottom: 0;
                margin-right: 12px;
            }

            .detail-card .detail-label {
                margin-bottom: 0;
                flex: 1;
                text-align: left;
            }

            .detail-card .detail-value {
                font-size: 16px;
            }

            .sun, .moon {
                width: 70px;
                height: 70px;
                top: 5%;
                right: 8%;
            }
        }
    </style>
</head>

<body>

    <!-- ☀️ SUN (Sunny day) -->
    <div class="sun" id="sun"></div>
    <div class="sun-rays" id="sunRays"></div>

    <!-- 🌙 MOON (Sunny night) -->
    <div class="moon" id="moon"></div>

    <!-- ⭐ STARS (Night) -->
    <div class="stars-container" id="starsContainer"></div>

    <!-- ☁️ CLOUDS -->
    <div class="clouds-container" id="cloudsContainer"></div>

    <!-- 🌧️ RAIN -->
    <div class="rain-container" id="rainContainer"></div>

    <!-- ❄️ SNOW -->
    <div class="snow-container" id="snowContainer"></div>

    <!-- 🌫️ FOG -->
    <div class="fog-container" id="fogContainer">
        <div class="fog-layer"></div>
        <div class="fog-layer"></div>
        <div class="fog-layer"></div>
        <div class="fog-layer"></div>
    </div>

    <!-- ⚡ LIGHTNING -->
    <div class="lightning-flash" id="lightningFlash"></div>
    <div class="lightning-bolt" id="lightningBolt"></div>

    <div class="container">

        <div class="header">
            <span class="icon">🌤️</span>
            <h1>Weather App</h1>
            <p class="subtitle">Check the weather in your city</p>
        </div>

        <form action="<?php echo e(route('weather')); ?>" method="GET">
            <input
                type="text"
                name="city"
                placeholder="Enter city name..."
                value="<?php echo e($city ?? ''); ?>"
                required
            >

            <button type="submit">Search</button>
        </form>

        <p class="hint">Example: Colombo, Gampaha, Kandy</p>

        <?php if(!empty($error)): ?>
            <div class="error">
                <?php echo e($error); ?>

            </div>
        <?php endif; ?>

        <?php if(!empty($weather)): ?>
            <?php
                $code = $weather['weather_code'] ?? -1;

                if ($code == 0) {
                    $condition = 'Clear sky';
                    $conditionIcon = '☀️';
                    $weatherClass = 'weather-clear';
                } elseif (in_array($code, [1, 2, 3])) {
                    $condition = 'Partly cloudy';
                    $conditionIcon = '🌤️';
                    $weatherClass = 'weather-cloudy';
                } elseif (in_array($code, [45, 48])) {
                    $condition = 'Foggy';
                    $conditionIcon = '🌫️';
                    $weatherClass = 'weather-fog';
                } elseif (in_array($code, [51, 53, 55, 56, 57])) {
                    $condition = 'Drizzle';
                    $conditionIcon = '🌦️';
                    $weatherClass = 'weather-rain';
                } elseif (in_array($code, [61, 63, 65, 66, 67, 80, 81, 82])) {
                    $condition = 'Rainy';
                    $conditionIcon = '🌧️';
                    $weatherClass = 'weather-rain';
                } elseif (in_array($code, [71, 73, 75, 77, 85, 86])) {
                    $condition = 'Snowy';
                    $conditionIcon = '❄️';
                    $weatherClass = 'weather-snow';
                } elseif (in_array($code, [95, 96, 99])) {
                    $condition = 'Thunderstorm';
                    $conditionIcon = '⛈️';
                    $weatherClass = 'weather-thunder';
                } else {
                    $condition = 'Weather information available';
                    $conditionIcon = '🌡️';
                    $weatherClass = 'weather-clear';
                }

                // Determine day/night
                $hour = (int) date('H');
                $isDay = ($hour >= 6 && $hour < 18);
            ?>

            <div class="weather-result" 
                 data-weather="<?php echo e($weatherClass); ?>" 
                 data-time="<?php echo e($isDay ? 'day' : 'night'); ?>">

                <div class="location">
                    <h2><?php echo e($weather['city']); ?></h2>
                    <div class="country"><?php echo e($weather['country']); ?></div>
                </div>

                <div class="temperature">
                    <?php echo e($weather['temperature_2m'] ?? '--'); ?><span class="unit">°C</span>
                </div>

                <div class="condition">
                    <?php echo e($conditionIcon); ?> <?php echo e($condition); ?>

                </div>

                <div class="details-grid">
                    <div class="detail-card">
                        <span class="detail-icon">🌡️</span>
                        <div class="detail-label">Feels Like</div>
                        <div class="detail-value">
                            <?php echo e($weather['apparent_temperature'] ?? '--'); ?><span class="small-unit">°C</span>
                        </div>
                    </div>

                    <div class="detail-card">
                        <span class="detail-icon">💧</span>
                        <div class="detail-label">Humidity</div>
                        <div class="detail-value">
                            <?php echo e($weather['relative_humidity_2m'] ?? '--'); ?><span class="small-unit">%</span>
                        </div>
                    </div>

                    <div class="detail-card">
                        <span class="detail-icon">💨</span>
                        <div class="detail-label">Wind</div>
                        <div class="detail-value">
                            <?php echo e($weather['wind_speed_10m'] ?? '--'); ?><span class="small-unit">km/h</span>
                        </div>
                    </div>
                </div>

            </div>
        <?php endif; ?>

        <div class="footer">
            Weather data by Open-Meteo
        </div>

    </div>

<script>
    // ============================================================
    // WEATHER ANIMATION ENGINE
    // ============================================================
    (function() {
        const rainContainer = document.getElementById('rainContainer');
        const snowContainer = document.getElementById('snowContainer');
        const cloudsContainer = document.getElementById('cloudsContainer');
        const fogContainer = document.getElementById('fogContainer');
        const starsContainer = document.getElementById('starsContainer');
        const lightningFlash = document.getElementById('lightningFlash');
        const lightningBolt = document.getElementById('lightningBolt');

        // ============ RAIN ============
        function createRain(intensity) {
            rainContainer.innerHTML = '';
            const dropCount = intensity === 'heavy' ? 160 : 100;
            for (let i = 0; i < dropCount; i++) {
                const drop = document.createElement('div');
                drop.className = 'rain-drop';
                drop.style.left = Math.random() * 100 + '%';
                if (intensity === 'heavy') {
                    drop.style.height = (Math.random() * 50 + 80) + 'px';
                    drop.style.animationDuration = (Math.random() * 0.3 + 0.3) + 's';
                    drop.style.opacity = Math.random() * 0.5 + 0.4;
                    drop.style.width = '3px';
                } else {
                    drop.style.height = (Math.random() * 50 + 50) + 'px';
                    drop.style.animationDuration = (Math.random() * 0.4 + 0.5) + 's';
                    drop.style.opacity = Math.random() * 0.4 + 0.25;
                }
                drop.style.animationDelay = (Math.random() * 2) + 's';
                rainContainer.appendChild(drop);
            }
            rainContainer.classList.add('active');
        }

        // ============ SNOW ============
        function createSnow() {
            snowContainer.innerHTML = '';
            const flakeCount = 70;
            const snowChars = ['❄', '❅', '❆', '•', '✻', '✼'];
            for (let i = 0; i < flakeCount; i++) {
                const flake = document.createElement('div');
                flake.className = 'snow-flake';
                flake.textContent = snowChars[Math.floor(Math.random() * snowChars.length)];
                flake.style.left = Math.random() * 100 + '%';
                flake.style.fontSize = (Math.random() * 12 + 8) + 'px';
                flake.style.animationDuration = (Math.random() * 5 + 5) + 's';
                flake.style.animationDelay = (Math.random() * 6) + 's';
                flake.style.opacity = Math.random() * 0.6 + 0.4;
                snowContainer.appendChild(flake);
            }
            snowContainer.classList.add('active');
        }

        // ============ CLOUDS ============
        function createClouds(dark, count) {
            cloudsContainer.innerHTML = '';
            const cloudCount = count || 6;
            for (let i = 0; i < cloudCount; i++) {
                const cloud = document.createElement('div');
                cloud.className = 'cloud';
                const width = Math.random() * 200 + 180;
                const height = Math.random() * 60 + 50;
                cloud.style.width = width + 'px';
                cloud.style.height = height + 'px';
                cloud.style.top = (Math.random() * 55) + '%';
                cloud.style.animationDuration = (Math.random() * 40 + 60) + 's';
                cloud.style.animationDelay = (Math.random() * 30) + 's';
                
                if (dark) {
                    cloud.style.background = 'rgba(70, 80, 110, 0.35)';
                    cloud.style.filter = 'blur(12px)';
                } else {
                    cloud.style.background = 'rgba(255, 255, 255, ' + (Math.random() * 0.15 + 0.2) + ')';
                    cloud.style.filter = 'blur(10px)';
                }
                cloudsContainer.appendChild(cloud);
            }
            cloudsContainer.classList.add('active');
        }

        // ============ FOG ============
        function activateFog() {
            fogContainer.classList.add('active');
        }

        // ============ STARS ============
        function createStars() {
            starsContainer.innerHTML = '';
            const starCount = 80;
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                const size = Math.random() * 2 + 1;
                star.style.width = size + 'px';
                star.style.height = size + 'px';
                star.style.left = Math.random() * 100 + '%';
                star.style.top = Math.random() * 70 + '%';
                star.style.animationDuration = (Math.random() * 3 + 2) + 's';
                star.style.animationDelay = (Math.random() * 5) + 's';
                star.style.opacity = Math.random() * 0.7 + 0.3;
                starsContainer.appendChild(star);
            }
        }

        // ============ LIGHTNING ============
        let lightningInterval = null;

        function startLightning() {
            if (lightningInterval) clearInterval(lightningInterval);
            // First strike after short delay
            setTimeout(triggerLightning, 800);
            
            lightningInterval = setInterval(function() {
                if (Math.random() > 0.35) {
                    triggerLightning();
                }
            }, 2200);
        }

        function triggerLightning() {
            const isStrong = Math.random() > 0.5;
            
            // Flash screen
            lightningFlash.classList.remove('flash', 'flash-strong');
            void lightningFlash.offsetWidth;
            lightningFlash.classList.add(isStrong ? 'flash-strong' : 'flash');

            // Show bolt at random position
            lightningBolt.classList.remove('strike');
            void lightningBolt.offsetWidth;
            lightningBolt.style.left = (Math.random() * 60 + 20) + '%';
            lightningBolt.style.height = (Math.random() * 25 + 45) + 'vh';
            lightningBolt.classList.add('strike');
        }

        // ============ RESET ============
        function resetAll() {
            rainContainer.classList.remove('active');
            rainContainer.innerHTML = '';
            snowContainer.classList.remove('active');
            snowContainer.innerHTML = '';
            cloudsContainer.classList.remove('active');
            cloudsContainer.innerHTML = '';
            fogContainer.classList.remove('active');
            starsContainer.innerHTML = '';
            lightningFlash.classList.remove('flash', 'flash-strong');
            lightningBolt.classList.remove('strike');
            if (lightningInterval) {
                clearInterval(lightningInterval);
                lightningInterval = null;
            }
        }

        // ============================================================
        // APPLY WEATHER
        // ============================================================
        const weatherResult = document.querySelector('.weather-result');
        const body = document.body;

        if (weatherResult) {
            const weatherClass = weatherResult.getAttribute('data-weather');
            const timeOfDay = weatherResult.getAttribute('data-time'); // 'day' or 'night'
            const isNight = timeOfDay === 'night';

            // Apply classes
            body.classList.add(weatherClass);
            body.classList.add(isNight ? 'is-night' : 'is-day');

            resetAll();

            // ========== SUNNY (Clear) ==========
            if (weatherClass === 'weather-clear') {
                if (isNight) {
                    // 🌙 Night: moon + stars
                    createStars();
                } else {
                    // ☀️ Day: sun already visible via CSS
                    // Slow clouds passing
                    createClouds(false, 3);
                }
            }
            // ========== CLOUDY ==========
            else if (weatherClass === 'weather-cloudy') {
                createClouds(isNight, 7);
            }
            // ========== RAIN ==========
            else if (weatherClass === 'weather-rain') {
                createRain('normal');
                createClouds(true, 5);
            }
            // ========== THUNDERSTORM ==========
            else if (weatherClass === 'weather-thunder') {
                createRain('heavy');
                createClouds(true, 8);
                startLightning();
            }
            // ========== FOG ==========
            else if (weatherClass === 'weather-fog') {
                activateFog();
                createClouds(false, 3);
            }
            // ========== SNOW ==========
            else if (weatherClass === 'weather-snow') {
                createSnow();
                createClouds(isNight, 4);
            }
        } else {
            // Default - sunny day
            body.classList.add('weather-clear', 'is-day');
        }
    })();

    // ============================================================
    // GEOLOCATION
    // ============================================================
    window.addEventListener('load', function () {
        const params = new URLSearchParams(window.location.search);

        if (params.has('city')) return;
        if (params.has('latitude') && params.has('longitude')) return;

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    window.location.replace(
                        '/?latitude=' + latitude +
                        '&longitude=' + longitude
                    );
                },
                function () {
                    console.log('Location permission denied.');
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000
                }
            );
        }
    });
</script>
</body>
</html><?php /**PATH E:\Laraval\myproject\resources\views/welcome.blade.php ENDPATH**/ ?>