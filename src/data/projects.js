export const projects = [
  {
    id: 'rental-chatbot',
    title: 'Photography Rental Chatbot',
    tag: 'AI · Botpress · Supabase',
    github: 'https://github.com/LeeWeiHao0624/Photography-Rental-Chatbot',
    summary:
      'Botpress Cloud chatbot that automates photography gear rentals: booking, cancellation, and status lookup with live Supabase inventory.',
    detail:
      'GPT-4.1 validates Malaysian phone numbers and dates, cross-checks the equipment catalog, and calls PostgreSQL via REST for availability, pricing, and booking IDs.',
    cover: '/assets/chatbot-logo.png',
    coverAlt: 'Photography Rental chatbot logo',
    coverStyle: 'logo',
    slides: [
      {
        src: '/assets/chatbot-logo.png',
        title: 'Brand identity',
        caption: 'Logo for the photography equipment rental chatbot product.',
      },
      {
        src: '/assets/chatbot-demo.png',
        title: 'Chat demo',
        caption: 'End-to-end rental conversation with booking ID confirmation.',
      },
      {
        src: '/assets/chatbot-flow-overview.png',
        title: 'Flow overview',
        caption: 'Full Botpress flow from entry through booking and FAQs.',
      },
      {
        src: '/assets/chatbot-flow-entry.png',
        title: 'Entry & routing',
        caption: 'Intent routing into booking, cancellation, or status lookup.',
      },
      {
        src: '/assets/chatbot-flow-extraction.png',
        title: 'Booking extraction',
        caption: 'LLM collects customer details and equipment selections.',
      },
      {
        src: '/assets/chatbot-flow-validation.png',
        title: 'Validation',
        caption: 'Catalog cross-check and form validation before availability.',
      },
      {
        src: '/assets/chatbot-flow-confirmation.png',
        title: 'Confirmation',
        caption: 'Pricing, availability check, and reservation write to Supabase.',
      },
    ],
  },
  {
    id: 'juju',
    title: 'Juju Connect',
    tag: 'Full-stack PHP',
    github: 'https://github.com/LeeWeiHao0624/JuJuConnect',
    summary:
      'Carpooling platform with custom PHP backend: ride scheduling, bookings, and multi-role dashboards (passenger, driver, admin, moderator).',
    detail:
      '12-table normalized MySQL schema, role-based flows, and responsive UI for mobile booking.',
    cover: '/assets/juju-main.png',
    slides: [
      {
        src: '/assets/juju-passenger.png',
        title: 'Passenger dashboard',
        caption: 'Ride history, carbon savings, and browse/book flows.',
      },
      {
        src: '/assets/juju-driver.png',
        title: 'Driver dashboard',
        caption: 'Offer rides, manage requests, track eco-points.',
      },
      {
        src: '/assets/juju-admin.png',
        title: 'Admin dashboard',
        caption: 'System metrics, environmental impact, activity logs.',
      },
      {
        src: '/assets/juju-moderator.png',
        title: 'Moderator dashboard',
        caption: 'Flagged rides, user reports, platform health.',
      },
      {
        src: '/assets/juju-mobile.png',
        title: 'Mobile layout',
        caption: 'Touch-friendly navigation for on-the-go use.',
      },
    ],
  },
  {
    id: 'tamago',
    title: 'Tamago Calculator',
    tag: 'Python automation',
    github: 'https://github.com/LeeWeiHao0624/Automated-Production-Calculator',
    summary:
      'Python and Selenium tool that syncs factory data and calculates daily production requirements, replacing manual spreadsheet entry.',
    detail:
      'Focused arithmetic logic, maintainable structure, and a minimal UI for floor staff.',
    cover: '/assets/tamago-main.png',
    slides: [
      {
        src: '/assets/tamago-standard.png',
        title: 'Standard view',
        caption: 'Auto-sync from external systems into production plans.',
      },
      {
        src: '/assets/tamago-manual.png',
        title: 'Manual entry',
        caption: 'Ingredient blocks from manual daily targets.',
      },
      {
        src: '/assets/tamago-mobile.png',
        title: 'Mobile layout',
        caption: 'Responsive layout for warehouse devices.',
      },
    ],
  },
];

export const EMAIL = 'weihao.lee.works@gmail.com';
export const CV_PATH = '/assets/Lee Wei Hao CV.pdf';
export const GITHUB = 'https://github.com/LeeWeiHao0624';
export const LINKEDIN = 'https://www.linkedin.com/in/wei-hao-lee-691ba83ab';
