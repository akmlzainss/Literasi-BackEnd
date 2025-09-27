<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Feed - SIPENA</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0073E6;
            --white: #ffffff;
            --dark: #111827;
        }
        body, html {
            height: 100%;
            margin: 0;
            background-color: #000;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }
        .tiktok-container {
            height: 100vh;
            width: 100%;
            scroll-snap-type: y mandatory;
            overflow-y: scroll;
            overflow-x: hidden;
        }
        .video-slide {
            height: 100vh;
            width: 100%;
            scroll-snap-align: start;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .video-player {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .video-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 20px;
            color: white;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            z-index: 10;
        }
        .video-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .video-author {
            font-size: 0.9rem;
            font-weight: 500;
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 20;
            color: white;
            font-size: 1.5rem;
            text-decoration: none;
            background: rgba(0,0,0,0.5);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <a href="{{ route('video.index') }}" class="back-button"><i class="fas fa-arrow-left"></i></a>

    <div class="tiktok-container" id="tiktok-container">
        @foreach($videos as $video)
        <div class="video-slide" id="video-{{$video->id}}">
            <video class="video-player" loop muted playsinline>
                <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="video-overlay">
                <h5 class="video-title">{{ $video->judul }}</h5>
                <p class="video-author"><i class="fas fa-user-circle me-2"></i>{{ $video->siswa->nama ?? 'Admin' }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const videos = document.querySelectorAll('.video-player');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.play();
                    } else {
                        entry.target.pause();
                    }
                });
            }, { threshold: 0.5 });

            videos.forEach(video => {
                observer.observe(video);
            });
        });
    </script>
</body>
</html>
