import { useState } from 'react';
import { projects } from '../data/projects.js';
import ProjectGallery from './ProjectGallery.jsx';

export default function Projects() {
  const [activeId, setActiveId] = useState(null);
  const active = projects.find((p) => p.id === activeId);

  return (
    <section id="projects" className="section" aria-labelledby="projects-heading">
      <div className="container">
        <p className="section-label">Work</p>
        <h2 id="projects-heading" className="section-heading">
          Technical projects
        </h2>
        <ul className="project-list">
          {projects.map((project) => (
            <li key={project.id} className="project-row">
              <div className="project-meta text-justify">
                <span className="project-tag">{project.tag}</span>
                <h3>{project.title}</h3>
                <p>{project.summary}</p>
                <p>{project.detail}</p>
                <div className="project-actions">
                  <button
                    type="button"
                    className="btn-text"
                    onClick={() => setActiveId(project.id)}
                  >
                    View gallery
                  </button>
                  <a
                    href={project.github}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn-text"
                  >
                    GitHub repo
                  </a>
                </div>
              </div>
              <div
                className={`project-thumb${project.coverStyle === 'logo' ? ' project-thumb--logo' : ''}`}
              >
                <img
                  src={project.cover}
                  alt={project.coverAlt ?? ''}
                  loading="lazy"
                />
              </div>
            </li>
          ))}
        </ul>
      </div>
      {active && (
        <ProjectGallery slides={active.slides} onClose={() => setActiveId(null)} />
      )}
    </section>
  );
}
