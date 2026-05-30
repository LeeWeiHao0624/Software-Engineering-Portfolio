import { EMAIL } from '../data/projects.js';

export default function Contact() {
  return (
    <section id="contact" className="section" aria-labelledby="contact-heading">
      <div className="container">
        <p className="section-label">Contact</p>
        <h2 id="contact-heading" className="section-heading">
          Get in touch
        </h2>
        <div className="contact-block">
          <a className="contact-email" href={`mailto:${EMAIL}`}>
            {EMAIL}
          </a>
          <p className="contact-note">
            For internship opportunities or technical questions. I reply within a few business days.
          </p>
        </div>
      </div>
    </section>
  );
}
