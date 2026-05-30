import { useState } from 'react';
import { CV_PATH, EMAIL, GITHUB, LINKEDIN } from '../data/projects.js';

const STACK = ['PHP', 'Python', 'MySQL', 'HTML & CSS', 'Selenium'];

const PROFILE_SRC = '/assets/profile.jpg';

function HeroPortrait() {
  const [hasPhoto, setHasPhoto] = useState(true);

  return (
    <div className="hero-portrait">
      {hasPhoto ? (
        <img
          src={PROFILE_SRC}
          alt="Weihao Lee, software engineering student"
          width={280}
          height={280}
          onError={() => setHasPhoto(false)}
        />
      ) : (
        <span className="hero-portrait-initials" aria-hidden="true">
          WL
        </span>
      )}
    </div>
  );
}

export default function Hero() {
  return (
    <section id="hero" className="hero" aria-labelledby="hero-heading">
      <div className="container hero-grid">
        <div className="hero-copy">
          <p className="hero-eyebrow reveal">Software engineering · Internship</p>
          <h1 id="hero-heading" className="hero-title reveal reveal-delay-1">
            Weihao Lee
          </h1>
          <p className="hero-lead reveal reveal-delay-2">
            Backend developer building PHP and Python systems with MySQL. Diploma student focused on
            full-stack delivery recruiters can scan in one pass.
          </p>
          <div className="hero-actions reveal reveal-delay-2">
            <a className="btn btn-primary" href="#projects">
              View projects
            </a>
            <a className="btn btn-ghost" href={CV_PATH} download="Lee-Wei-Hao-CV.pdf">
              Download CV
            </a>
          </div>
          <div className="hero-links reveal reveal-delay-2">
            <a href={GITHUB} target="_blank" rel="noopener noreferrer">
              GitHub
            </a>
            <a href={LINKEDIN} target="_blank" rel="noopener noreferrer">
              LinkedIn
            </a>
            <a href={`mailto:${EMAIL}`}>{EMAIL}</a>
          </div>
        </div>

        <aside className="hero-aside reveal reveal-delay-2" aria-label="Profile highlights">
          <HeroPortrait />
          <p className="hero-aside-label">Core stack</p>
          <ul className="hero-stack">
            {STACK.map((item) => (
              <li key={item}>{item}</li>
            ))}
          </ul>
          <dl className="hero-facts">
            <div>
              <dt>Focus</dt>
              <dd>Backend & data layers</dd>
            </div>
            <div>
              <dt>Projects</dt>
              <dd>3 shipped projects</dd>
            </div>
          </dl>
        </aside>
      </div>
    </section>
  );
}
