import { useCallback, useEffect, useState } from 'react';

export default function ProjectGallery({ slides, onClose }) {
  const [index, setIndex] = useState(0);
  const slide = slides[index];
  const total = slides.length;

  const go = useCallback(
    (delta) => {
      setIndex((i) => (i + delta + total) % total);
    },
    [total],
  );

  useEffect(() => {
    const onKey = (e) => {
      if (e.key === 'Escape') onClose();
      if (e.key === 'ArrowLeft') go(-1);
      if (e.key === 'ArrowRight') go(1);
    };
    document.addEventListener('keydown', onKey);
    const prevOverflow = document.body.style.overflow;
    document.body.style.overflow = 'hidden';
    return () => {
      document.removeEventListener('keydown', onKey);
      document.body.style.overflow = prevOverflow;
    };
  }, [go, onClose]);

  return (
    <div
      className="modal-backdrop"
      role="presentation"
      onClick={(e) => {
        if (e.target === e.currentTarget) onClose();
      }}
    >
      <div className="modal" role="dialog" aria-modal="true" aria-labelledby="gallery-title">
        <div className="modal-header">
          <h2 id="gallery-title">
            Gallery · {index + 1} / {total}
          </h2>
          <button type="button" className="modal-close" aria-label="Close gallery" onClick={onClose}>
            ×
          </button>
        </div>
        <div className="modal-body">
          <div className="carousel">
            <div className="carousel-frame">
              <img src={slide.src} alt={slide.title} loading="lazy" />
            </div>
            <div className="carousel-caption">
              <h3>{slide.title}</h3>
              <p>{slide.caption}</p>
            </div>
            <div className="carousel-controls">
              <div className="carousel-dots" role="tablist" aria-label="Slides">
                {slides.map((s, i) => (
                  <button
                    key={s.src}
                    type="button"
                    className={`carousel-dot${i === index ? ' is-active' : ''}`}
                    aria-label={`Slide ${i + 1}`}
                    aria-selected={i === index}
                    onClick={() => setIndex(i)}
                  />
                ))}
              </div>
              <div className="carousel-nav">
                <button type="button" onClick={() => go(-1)}>
                  Previous
                </button>
                <button type="button" onClick={() => go(1)}>
                  Next
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
