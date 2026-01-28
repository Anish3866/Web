import HeadphoneScroll from "@/components/HeadphoneScroll";

export default function Home() {
  return (
    <main className="flex min-h-screen flex-col items-center justify-between">
      <HeadphoneScroll />

      {/* Additional Content Below Scroll */}
      <footer className="w-full h-[50vh] bg-black border-t border-white/10 flex flex-col items-center justify-center p-10 z-20 relative">
        <h3 className="text-2xl font-bold text-white mb-4">Zenith X</h3>
        <p className="text-white/40 max-w-sm text-center mb-8">
          Redefining the auditory experience through precision engineering and titanium architecture.
        </p>
        <div className="flex gap-8 text-sm text-white/60">
          <a href="#" className="hover:text-white transition-colors">Instagram</a>
          <a href="#" className="hover:text-white transition-colors">Twitter</a>
          <a href="#" className="hover:text-white transition-colors">Support</a>
        </div>
        <p className="absolute bottom-5 text-white/20 text-xs">© 2024 Zenith Audio. Fictional Brand.</p>
      </footer>
    </main>
  );
}
