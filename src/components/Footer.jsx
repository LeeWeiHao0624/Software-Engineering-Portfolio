import { GITHUB, LINKEDIN } from '../data/projects.js';

export default function Footer() {
  const year = new Date().getFullYear();

  return (
    <footer className="site-footer">
      <div className="container footer-inner">
        <p>© {year} Weihao Lee</p>
        <div className="footer-links">
          <a href={GITHUB} target="_blank" rel="noopener noreferrer">
            GitHub
          </a>
          <a href={LINKEDIN} target="_blank" rel="noopener noreferrer">
            LinkedIn
          </a>
        </div>
      </div>
    </footer>
  );
}
