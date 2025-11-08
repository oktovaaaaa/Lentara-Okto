{{-- resources/views/landing.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lentara Islands</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@500&display=swap" rel="stylesheet">

    {{-- Tailwind via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Inter", sans-serif;
        }

        .card {
            position: absolute;
            background-size: cover;
            background-position: center; /* default (desktop / tablet) */
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            color: #ffffffdd;
            cursor: pointer;
        }

        /* HP & layar kecil: geser gambar ke kanan (rata kanan) */
        @media (max-width: 768px) {
            .card {
                background-position: right center;
            }
        }

        .indicator {
            position: absolute;
            bottom: 80px;
            left: 0;
            width: 100%;
            height: 4px;
            background: #ecad29;
            transform: translateX(-100%);
        }

        .cover {
            position: absolute;
            top: 0;
            left: 0;
            width: 200%;
            height: 100%;
            background: #1a1a1a;
            z-index: 99;
        }

        .content-title-1,
        .content-title-2 {
            font-family: "Oswald", sans-serif;
        }
    </style>
</head>

@php
    $hasSelected    = isset($selectedIsland) && $selectedIsland;
    $featuresByType = $featuresByType ?? [];
@endphp

<body class="bg-[#1a1a1a] text-white {{ $hasSelected ? '' : 'overflow-hidden' }}">

    <div class="cover"></div>

    {{-- JUDUL BESAR (FIXED) --}}
    @if($hasSelected)
    <div
        class="pointer-events-none fixed z-[150]
               inset-x-0
               top-16 sm:top-20                {{-- HP & tablet: agak di atas, bukan di tengah --}}
               flex justify-center
               px-4 sm:px-6
               text-center
               md:top-16                        {{-- desktop tetap di atas kiri --}}
               md:justify-start md:text-left
               md:px-10">
        <div class="max-w-3xl space-y-2">
            @if($selectedIsland->place_label)
                <p class="hero-title-line text-[9px] sm:text-[10px] md:text-xs tracking-[0.3em] uppercase text-white/80">
                    {{ $selectedIsland->place_label }}
                </p>
            @endif

            <h1
                class="hero-title-line content-title-1
                       text-3xl sm:text-4xl md:text-6xl lg:text-7xl
                       font-bold leading-tight sm:leading-none drop-shadow-[0_0_20px_rgba(0,0,0,0.7)]">
                {{ strtoupper($selectedIsland->title ?? $selectedIsland->name) }}
            </h1>

            @if($selectedIsland->subtitle)
                <p
                    class="hero-title-line content-title-2
                           text-lg sm:text-2xl md:text-3xl lg:text-4xl
                           font-semibold text-white drop-shadow-[0_0_20px_rgba(0,0,0,0.7)]">
                    {{ strtoupper($selectedIsland->subtitle) }}
                </p>
            @endif
        </div>
    </div>
@endif
    

    {{-- AREA ANIMASI KARTU --}}
    <div id="demo" class="relative w-screen h-screen overflow-hidden"></div>

    {{-- PAGINATION & NOMOR SLIDE --}}
    <div
        id="pagination"
        class="absolute bottom-16 sm:bottom-12 left-1/2 -translate-x-1/2 flex gap-2 text-white text-xs sm:text-sm"
    >
        <div class="progress-sub-foreground"></div>
    </div>

    <div
        id="slide-numbers"
        class="absolute bottom-8 sm:bottom-6 left-1/2 -translate-x-1/2 flex gap-2 text-[14px] sm:text-[18px]"
    ></div>

    <div class="indicator"></div>

    {{-- SECTION BAWAH: ABOUT / HISTORY / DESTINASI / MAKANAN / BUDAYA --}}
    @if($hasSelected)
        <section class="relative z-[10] bg-[#050505] text-white py-12 sm:py-16 px-4 sm:px-6">
            <div class="max-w-5xl mx-auto space-y-12">

                {{-- ABOUT --}}
                <div id="about">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-semibold mb-3">
                        Tentang {{ $selectedIsland->title ?? $selectedIsland->name }}
                    </h2>
                    <p class="text-sm sm:text-base text-white/80 leading-relaxed">
                        {{ $selectedIsland->short_description ?? 'Belum ada deskripsi singkat. Tambahkan konten about di database.' }}
                    </p>

                    @if(!empty($featuresByType['about']) && $featuresByType['about']->count())
                        <div class="mt-4 space-y-3">
                            @foreach($featuresByType['about'] as $about)
                                <div>
                                    <h3 class="text-sm sm:text-base font-semibold mb-1">{{ $about->title }}</h3>
                                    <p class="text-xs sm:text-sm text-white/70 leading-relaxed">
                                        {{ $about->description }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- HISTORY --}}
                @if(!empty($featuresByType['history']) && $featuresByType['history']->count())
                    <div id="history">
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-semibold mb-3">
                            Sejarah Singkat
                        </h2>
                        <div class="space-y-4">
                            @foreach($featuresByType['history'] as $history)
                                <div class="border border-white/10 rounded-2xl p-4">
                                    <h3 class="text-sm sm:text-base font-semibold mb-1">{{ $history->title }}</h3>
                                    <p class="text-xs sm:text-sm text-white/70 leading-relaxed">
                                        {{ $history->description }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- DESTINASI --}}
                @if(!empty($featuresByType['destination']) && $featuresByType['destination']->count())
                    <div id="destinations">
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-semibold mb-3">
                            Destinasi Populer
                        </h2>
                        <div class="grid sm:grid-cols-2 gap-4">
                            @foreach($featuresByType['destination'] as $dest)
                                <div class="border border-white/10 rounded-2xl p-4 flex gap-3">
                                    @if($dest->image_url)
                                        <img
                                            src="{{ $dest->image_url }}"
                                            alt="{{ $dest->title }}
                                            class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-lg border border-white/10 flex-shrink-0">
                                    @endif
                                    <div>
                                        <h3 class="text-sm sm:text-base font-semibold mb-1">
                                            {{ $dest->title }}
                                        </h3>
                                        @if($dest->description)
                                            <p class="text-xs sm:text-sm text-white/70 leading-relaxed">
                                                {{ $dest->description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- MAKANAN KHAS --}}
                @if(!empty($featuresByType['food']) && $featuresByType['food']->count())
                    <div id="foods">
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-semibold mb-3">
                            Makanan Khas
                        </h2>
                        <div class="grid sm:grid-cols-2 gap-4">
                            @foreach($featuresByType['food'] as $food)
                                <div class="border border-white/10 rounded-2xl p-4 flex gap-3">
                                    @if($food->image_url)
                                        <img
                                            src="{{ $food->image_url }}"
                                            alt="{{ $food->title }}"
                                            class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-lg border border-white/10 flex-shrink-0">
                                    @endif
                                    <div>
                                        <h3 class="text-sm sm:text-base font-semibold mb-1">
                                            {{ $food->title }}
                                        </h3>
                                        <p class="text-xs sm:text-sm text-white/70">
                                            {{ $food->description }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- BUDAYA --}}
                @if(!empty($featuresByType['culture']) && $featuresByType['culture']->count())
                    <div id="cultures">
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-semibold mb-3">
                            Budaya & Tradisi
                        </h2>
                        <div class="space-y-4">
                            @foreach($featuresByType['culture'] as $culture)
                                <div class="border border-white/10 rounded-2xl p-4">
                                    <h3 class="text-sm sm:text-base font-semibold mb-1">
                                        {{ $culture->title }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-white/70 leading-relaxed">
                                        {{ $culture->description }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </section>
    @endif

    {{-- GSAP --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script>
        // ===== DATA DARI LARAVEL =====
        const data        = @json($carouselData);
        const initialSlug = @json(optional($selectedIsland)->slug);

        const _ = (id) => document.getElementById(id);

        // Bangun HTML card dari data
        const cards = data.map((i, index) => `
          <div
            class="card"
            id="card${index}"
            data-slug="${i.slug}"
            style="background-image:url(${i.image})"
          >
            <div class="card-content bg-gradient-to-t from-black/60 to-transparent p-4 sm:p-5">
              <div class="content-place text-[11px] sm:text-[13px] tracking-[1px] opacity-80 uppercase">
                ${i.place ?? ''}
              </div>
              <div class="content-title-1 text-[22px] sm:text-[26px] leading-none">
                ${i.title ?? ''}
              </div>
              <div class="content-title-2 text-[18px] sm:text-[22px] leading-none">
                ${i.title2 ?? ''}
              </div>
            </div>
          </div>
        `).join('');

        _('demo').innerHTML = cards;

        // Nomor slide
        const slideNumbers = data
            .map((_, index) => `<div class="item" id="slide-item-${index}">${index + 1}</div>`)
            .join('');
        _('slide-numbers').innerHTML = slideNumbers;

        // Klik kartu → pindah ke halaman pulau (tab yang sama)
        function attachCardClicks() {
            const cardElements = document.querySelectorAll('.card');

            cardElements.forEach((card, index) => {
                const slugFromData = data[index]?.slug || card.dataset.slug;
                if (!slugFromData) return;

                card.addEventListener('click', () => {
                    window.location.href = `/islands/${slugFromData}`;
                });
            });
        }

        // ===== LOGIKA ANIMASI GSAP =====
        const range = (n) => Array(n).fill(0).map((_, j) => j);
        const set   = gsap.set;
        const ease  = "sine.inOut";

        function getCard(index)       { return `#card${index}`; }
        function getSliderItem(index) { return `#slide-item-${index}`; }

        // default order: [0,1,2,...]
        let order = range(data.length);

        // kalau ada pulau yang dipilih, jadikan dia index pertama
        if (initialSlug) {
            const idx = data.findIndex(item => item.slug === initialSlug);
            if (idx > 0) {
                order = [
                    ...order.slice(idx),
                    ...order.slice(0, idx),
                ];
            }
        }

        let offsetTop   = 200;
        let offsetLeft  = 700;
        let cardWidth   = 200;
        let cardHeight  = 300;
        let gap         = 40;
        let numberSize  = 50;

        function animate(target, duration, properties) {
            return new Promise((resolve) => {
                gsap.to(target, {
                    ...properties,
                    duration,
                    onComplete: resolve
                });
            });
        }

        function setupLayout() {
            const { innerHeight: height, innerWidth: width } = window;

            // layout desktop / tablet
            if (width >= 768) {
                cardWidth  = 220;
                cardHeight = 320;
                offsetTop  = height - 430;
                offsetLeft = width - 830;
                gap        = 40;
            } else {
                // layout mobile / tablet kecil (portrait)
                cardWidth  = Math.min(width * 0.75, 260);
                cardHeight = Math.min(height * 0.45, 280);
                offsetTop  = height - (cardHeight + 110);
                offsetLeft = width - (cardWidth * 1.9);
                gap        = 24;
            }
        }

        function init() {
            if (!data.length) {
                console.warn('Tidak ada data island di database.');
                return;
            }

            setupLayout();

            const [active, ...rest] = order;
            const { innerHeight: height, innerWidth: width } = window;

            gsap.set(".cover", { x: 0 });
            gsap.set(getCard(active), { x: 0, y: 0, width: width, height: height, borderRadius: 0 });

            rest.forEach((i, index) => {
                gsap.set(getCard(i), {
                    x: offsetLeft + 400 + index * (cardWidth + gap),
                    y: offsetTop,
                    width: cardWidth,
                    height: cardHeight,
                    zIndex: 30
                });
            });

            gsap.to(".cover", {
                x: width + 400,
                duration: 1.2,
                ease,
                onComplete: () => loop()
            });
        }

        function step() {
            return new Promise((resolve) => {
                order.push(order.shift());
                const [active, ...rest] = order;
                const prv = rest[rest.length - 1];

                gsap.set(getCard(prv),    { zIndex: 10 });
                gsap.set(getCard(active), { zIndex: 20 });
                gsap.to(getCard(prv),     { scale: 1.5, ease });

                gsap.to(getCard(active), {
                    x: 0,
                    y: 0,
                    ease,
                    width: window.innerWidth,
                    height: window.innerHeight,
                    borderRadius: 0,
                    onComplete: () => {
                        const xNew = offsetLeft + (rest.length - 1) * (cardWidth + gap);
                        gsap.set(getCard(prv), {
                            x: xNew,
                            y: offsetTop,
                            width: cardWidth,
                            height: cardHeight,
                            zIndex: 30,
                            scale: 1,
                            borderRadius: 10
                        });
                        gsap.set(getSliderItem(prv), { x: rest.length * numberSize });
                        resolve();
                    }
                });

                rest.forEach((i, index) => {
                    if (i !== prv) {
                        const xNew = offsetLeft + index * (cardWidth + gap);
                        gsap.to(getCard(i), {
                            x: xNew,
                            y: offsetTop,
                            width: cardWidth,
                            height: cardHeight,
                            ease,
                            delay: 0.1 * (index + 1)
                        });
                    }
                });
            });
        }

        async function loop() {
            await animate(".indicator", 2,   { x: 0 });
            await animate(".indicator", 0.8, { x: window.innerWidth, delay: 0.3 });
            set(".indicator", { x: -window.innerWidth });
            await step();
            loop();
        }

        function loadImage(src) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload  = () => resolve(img);
                img.onerror = reject;
                img.src     = src;
            });
        }

        async function loadImages() {
            const promises = data.map(({ image }) => loadImage(image));
            return Promise.all(promises);
        }

        function animateHeroTitle() {
            if (!initialSlug) return;

            gsap.from(".hero-title-line", {
                y: 40,
                opacity: 0,
                duration: 1.1,
                ease: "power3.out",
                stagger: 0.15
            });
        }

        async function start() {
            if (!data.length) return;
            try {
                await loadImages();
                attachCardClicks();
                init();
                animateHeroTitle();
            } catch (e) {
                console.error("Image failed to load", e);
            }
        }

        // Re-init layout ketika resize
        window.addEventListener('resize', () => {
            setupLayout();
        });

        start();
    </script>
</body>
</html>
