"use client";

import React, { useRef, useEffect, useState, useCallback } from 'react';
import { useScroll, useTransform, useMotionValueEvent, motion } from 'framer-motion';

// CONFIGURATION
const FRAME_COUNT = 120;
// Note to User: Place your images in public/headphone_sequence/
// Naming: frame_000_delay-0.04s.webp, frame_001_delay-0.04s.webp, etc.
const IMAGE_FOLDER = '/headphone_sequence';
const FILENAME_PREFIX = 'frame_';
// Adjust suffix if your ezgif split has different naming
const FILENAME_SUFFIX = '_delay-0.04s.webp';

export default function HeadphoneScroll() {
    const containerRef = useRef<HTMLDivElement>(null);
    const canvasRef = useRef<HTMLCanvasElement>(null);
    const [images, setImages] = useState<HTMLImageElement[]>([]);
    const [isLoaded, setIsLoaded] = useState(false);

    // Initialize Scroll
    const { scrollYProgress } = useScroll({
        target: containerRef,
        offset: ["start start", "end end"]
    });

    // Map scroll to frame index (0 to 119)
    const renderIndex = useTransform(scrollYProgress, [0, 1], [0, FRAME_COUNT - 1]);

    // Text Opacity Transforms
    // 0% - Title
    const opacityTitle = useTransform(scrollYProgress, [0, 0.15, 0.25], [1, 1, 0]);

    // 30% - Precision Engineering (Left)
    const opacityFeature1 = useTransform(scrollYProgress, [0.25, 0.35, 0.45], [0, 1, 0]);
    const xFeature1 = useTransform(scrollYProgress, [0.25, 0.35], [-50, 0]); // Slide in slightly

    // 60% - Titanium Drivers (Right)
    const opacityFeature2 = useTransform(scrollYProgress, [0.55, 0.65, 0.75], [0, 1, 0]);
    const xFeature2 = useTransform(scrollYProgress, [0.55, 0.65], [50, 0]);

    // 90% - Hear Everything (Center CTA)
    const opacityCTA = useTransform(scrollYProgress, [0.85, 0.95, 1], [0, 1, 1]);
    const scaleCTA = useTransform(scrollYProgress, [0.85, 1], [0.8, 1]);

    // Handle Resize
    const handleResize = useCallback(() => {
        if (canvasRef.current) {
            canvasRef.current.width = window.innerWidth;
            canvasRef.current.height = window.innerHeight;
            // Trigger a redraw if possible or just wait for scroll
        }
    }, []);

    useEffect(() => {
        window.addEventListener('resize', handleResize);
        handleResize();
        return () => window.removeEventListener('resize', handleResize);
    }, [handleResize]);

    // Preload Images
    useEffect(() => {
        const loadedImages: HTMLImageElement[] = [];
        let loadedCount = 0;

        const onLoad = () => {
            loadedCount++;
            if (loadedCount === FRAME_COUNT) {
                setImages(loadedImages);
                setIsLoaded(true);
            }
        };

        for (let i = 0; i < FRAME_COUNT; i++) {
            const img = new Image();
            // Assuming 3-digit padding from ezgif usually
            const paddedIndex = i.toString().padStart(3, '0');
            img.src = `${IMAGE_FOLDER}/${FILENAME_PREFIX}${paddedIndex}${FILENAME_SUFFIX}`;
            img.onload = onLoad;
            img.onerror = () => {
                // If image fails, count it anyway to avoid blocking
                onLoad();
                console.warn(`Failed to generate/load frame ${i} at ${img.src}`);
            };
            loadedImages.push(img);
        }
    }, []);

    // Drawing Logic
    const renderFrame = (index: number) => {
        const canvas = canvasRef.current;
        const ctx = canvas?.getContext('2d');
        if (!canvas || !ctx) return;

        // Clear
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (isLoaded && images[index] && images[index].complete && images[index].naturalHeight !== 0) {
            const img = images[index];
            // "Contain" fit
            const hRatio = canvas.width / img.width;
            const vRatio = canvas.height / img.height;
            const ratio = Math.min(hRatio, vRatio);

            const centerShift_x = (canvas.width - img.width * ratio) / 2;
            const centerShift_y = (canvas.height - img.height * ratio) / 2;

            ctx.drawImage(img,
                0, 0, img.width, img.height,
                centerShift_x, centerShift_y, img.width * ratio, img.height * ratio
            );
        } else {
            // Fallback Debug View if images missing
            if (!isLoaded) return; // Don't show debug if loading
            ctx.font = "bold 40px Inter, sans-serif";
            ctx.fillStyle = "#333";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";
            ctx.fillText(`FRAME ${Math.floor(index)}`, canvas.width / 2, canvas.height / 2);
            ctx.font = "16px Inter, sans-serif";
            ctx.fillStyle = "#555";
            ctx.fillText(`(Place images in public${IMAGE_FOLDER})`, canvas.width / 2, canvas.height / 2 + 50);
        }
    };

    useMotionValueEvent(renderIndex, "change", (latest: number) => {
        requestAnimationFrame(() => renderFrame(Math.floor(latest)));
    });

    // Initial draw once loaded
    useEffect(() => {
        if (isLoaded) renderFrame(0);
    }, [isLoaded]);

    return (
        <div ref={containerRef} className="h-[400vh] relative bg-[#050505] w-full" suppressHydrationWarning>
            <div className="sticky top-0 h-screen w-full overflow-hidden">
                <canvas ref={canvasRef} className="absolute inset-0 w-full h-full" />

                {/* Loading State */}
                {!isLoaded && (
                    <div className="absolute inset-0 flex flex-col items-center justify-center bg-[#050505] z-50">
                        <div className="w-10 h-10 border-4 border-white/20 border-t-white/90 rounded-full animate-spin mb-4" />
                        <p className="text-white/50 text-sm tracking-widest uppercase">Loading Experience</p>
                    </div>
                )}

                {/* SECTION 1: 0% */}
                <motion.div
                    style={{ opacity: opacityTitle }}
                    className="absolute inset-0 flex items-center justify-center pointer-events-none z-10"
                >
                    <h1 className="text-5xl md:text-8xl font-bold tracking-tighter text-white/90 text-center uppercase">
                        Zenith X.<br /><span className="text-white/50">Pure Sound.</span>
                    </h1>
                </motion.div>

                {/* SECTION 2: 30% - Left */}
                <motion.div
                    style={{ opacity: opacityFeature1, x: xFeature1 }}
                    className="absolute inset-0 flex items-center justify-start px-8 md:px-24 pointer-events-none z-10"
                >
                    <div className="max-w-xl">
                        <h2 className="text-4xl md:text-6xl font-semibold tracking-tight text-white/90">Precision<br />Engineering.</h2>
                        <p className="mt-6 text-lg md:text-xl text-white/60 leading-relaxed font-light">
                            Every component is machined to micron-level tolerances, ensuring zero distortion and maximum acoustic fidelity.
                        </p>
                    </div>
                </motion.div>

                {/* SECTION 3: 60% - Right */}
                <motion.div
                    style={{ opacity: opacityFeature2, x: xFeature2 }}
                    className="absolute inset-0 flex items-center justify-end px-8 md:px-24 pointer-events-none z-10"
                >
                    <div className="max-w-xl text-right">
                        <h2 className="text-4xl md:text-6xl font-semibold tracking-tight text-white/90">Titanium<br />Drivers.</h2>
                        <p className="mt-6 text-lg md:text-xl text-white/60 leading-relaxed font-light">
                            Proprietary 50mm titanium-coated drivers deliver a soundstage so wide, you'll feel every instrument.
                        </p>
                    </div>
                </motion.div>

                {/* SECTION 4: 90% - Center CTA */}
                <motion.div
                    style={{ opacity: opacityCTA, scale: scaleCTA }}
                    className="absolute inset-0 flex items-center justify-center pointer-events-none z-20"
                >
                    <div className="text-center">
                        <h2 className="text-5xl md:text-7xl font-bold tracking-tighter text-white/90 mb-8">Hear Everything.</h2>
                        <button className="pointer-events-auto px-8 py-4 bg-white text-black font-semibold rounded-full text-lg hover:scale-105 transition-transform duration-300">
                            Pre-order Zenith X
                        </button>
                    </div>
                </motion.div>

                <div className="absolute bottom-10 w-full text-center text-white/20 text-xs uppercase tracking-widest pointer-events-none">
                    Scroll to Explore
                </div>
            </div>
        </div>
    )
}
