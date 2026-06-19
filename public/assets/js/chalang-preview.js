// CHALANG PREVIEW SYSTEM
// CHALANG PREVIEW SYSTEM
// ----------------------

document.addEventListener('DOMContentLoaded', () => {
  const apiKey = ''; // Put backend-proxied key here if enabled
  const enableAi = Boolean(apiKey);
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const isNarrow = () => window.matchMedia('(max-width: 900px)').matches;

  const themeBtn = document.getElementById('theme-toggle');
  const mobileThemeBtn = document.getElementById('mobile-theme-toggle');
  const html = document.documentElement;
  const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  const disableAos = () => {
    html.setAttribute('data-aos-disabled', 'true');
  };
  const readCookie = (name) => {
    const match = document.cookie.match(new RegExp('(^|;\\s*)' + name + '=([^;]*)'));
    return match ? decodeURIComponent(match[2]) : null;
  };
  const readStoredTheme = () => {
    const stored = window.Cookies ? Cookies.get('styleCookieName') : readCookie('styleCookieName');
    if (stored === 'dark' || stored === 'light') return stored;
    return null;
  };
  const persistTheme = (value) => {
    if (window.Cookies) {
      Cookies.set('styleCookieName', value, { expires: 7, path: '/' });
    } else {
      document.cookie = 'styleCookieName=' + encodeURIComponent(value) + '; path=/; max-age=604800';
    }
  };
  const applyTheme = (theme, persist = true) => {
    const next = theme === 'dark' ? 'dark' : 'light';
    html.setAttribute('data-theme', next);
    document.body.classList.toggle('active-dark-mode', next === 'dark');
    document.body.classList.toggle('active-light-mode', next === 'light');
    if (persist) {
      persistTheme(next);
    }
  };
  const initTheme = () => {
    const initial = readStoredTheme()
      || html.getAttribute('data-theme')
      || (prefersDark ? 'dark' : 'light');
    applyTheme(initial, false);
  };
  const toggleTheme = () => {
    const current = html.getAttribute('data-theme') || 'light';
    const next = current === 'light' ? 'dark' : 'light';
    applyTheme(next, true);
  };
  initTheme();
  if (!window.AOS) {
    disableAos();
  }
  if (themeBtn) themeBtn.addEventListener('click', toggleTheme);
  if (mobileThemeBtn) mobileThemeBtn.addEventListener('click', toggleTheme);

  if (typeof sal === 'function') {
    try {
      sal({ threshold: 0.1, once: true });
    } catch (e) {
      document.body.classList.add('sal-disabled');
    }
  } else {
    document.body.classList.add('sal-disabled');
  }

  const cursorDot = document.querySelector('.cursor-dot');
  const cursorOutline = document.querySelector('.cursor-outline');
  const canUseCustomCursor = () => !isNarrow();
  const enableCustomCursor = () => {
    if (!cursorDot || !cursorOutline || !canUseCustomCursor()) return;
    document.body.classList.add('custom-cursor');
    let lastX = -100;
    let lastY = -100;
    let rafId = null;
    const render = () => {
      cursorDot.style.left = lastX + 'px';
      cursorDot.style.top = lastY + 'px';
      cursorOutline.style.left = lastX + 'px';
      cursorOutline.style.top = lastY + 'px';
      rafId = null;
    };
    window.addEventListener('mousemove', (event) => {
      lastX = event.clientX;
      lastY = event.clientY;
      if (!rafId) rafId = window.requestAnimationFrame(render);
    });
    const hoverables = document.querySelectorAll(
      'a, button, input, textarea, select, .glass-card, .service-card, .nav-desktop a, .kinetic-card, .testimonial-card, .team-card, .project-card'
    );
    hoverables.forEach((el) => {
      hoverables.forEach((el) => {
        // User requested removal of cursor inversion effect
        // el.addEventListener('mouseenter', () => document.body.classList.add('hovering'));
        // el.addEventListener('mouseleave', () => document.body.classList.remove('hovering'));
      });
    });
  };
  enableCustomCursor();

  const getScrollState = () => {
    const doc = document.documentElement;
    const scroller = document.scrollingElement || doc;
    const nativeHeight = scroller.scrollHeight - scroller.clientHeight;
    const lenis = window.lenis;
    if (lenis && typeof lenis.scroll === 'number') {
      const limit = typeof lenis.limit === 'number' ? lenis.limit : nativeHeight;
      return { scrollTop: lenis.scroll || 0, height: limit || nativeHeight };
    }
    return {
      scrollTop: scroller.scrollTop || window.pageYOffset || 0,
      height: Math.max(scroller.scrollHeight, doc.scrollHeight) - scroller.clientHeight
    };
  };

  const bindScroll = (handler) => {
    window.addEventListener('scroll', handler, { passive: true });
    const attachLenis = () => {
      const lenis = window.lenis;
      if (lenis && typeof lenis.on === 'function') {
        lenis.on('scroll', handler);
        return true;
      }
      return false;
    };
    if (!attachLenis()) {
      window.addEventListener('lenis:ready', () => {
        attachLenis();
        handler();
      }, { once: true });
    }
  };

  /* UPDATED: Target the new docked rocket class */
  const progressWrap = document.querySelector('.docked-rocket');
  const progressBar = document.getElementById('scroll-progress');
  const updateScrollProgress = () => {
    // Scroll progress visualizer (if needed, or maybe just logic)
    // For now we just keep the variable, but the bar itself is #scroll-progress
    if (!progressBar) return;
    const { scrollTop, height } = getScrollState();
    const scrolled = height > 0 ? (scrollTop / height) * 100 : 0;
    progressBar.style.width = scrolled + '%';
  };

  const rocketBtn = document.getElementById('docked-rocket');
  if (rocketBtn) {
    rocketBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Use the existing scroll listener to toggle class
    const toggleRocket = () => {
      const { scrollTop } = getScrollState();
      if (scrollTop > 300) {
        rocketBtn.classList.add('active');
      } else {
        rocketBtn.classList.remove('active');
      }
    };
    window.addEventListener('scroll', toggleRocket);
  }

  /* -------------------------------------------------------------------------- */
  /*                              MOBILE NAVIGATION                             */
  /* -------------------------------------------------------------------------- */
  /* -------------------------------------------------------------------------- */
  /*                              MOBILE NAVIGATION                             */
  /* -------------------------------------------------------------------------- */

  // Delegated Event Listener for Mobile Menu
  document.addEventListener('click', (e) => {
    const target = e.target;
    const toggleBtn = target.closest('#mobile-menu-toggle');
    const closeBtn = target.closest('#close-menu');
    const menuLink = target.closest('#mobile-nav a');
    const mobileNav = document.getElementById('mobile-nav');

    if (!mobileNav) return;

    // Open Menu
    if (toggleBtn) {
      e.preventDefault();
      mobileNav.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    // Close Menu (Button or Link)
    if (closeBtn || menuLink) {
      if (closeBtn) e.preventDefault();
      mobileNav.classList.remove('active');
      document.body.style.overflow = '';
    }

    // Close if clicking outside checking strictly
    if (mobileNav.classList.contains('active') && !mobileNav.contains(target) && !toggleBtn) {
      mobileNav.classList.remove('active');
      document.body.style.overflow = '';
    }
  });

  // Function to toggle progress bar visibility based on scroll position
  const toggleProgressVisibility = () => {
    if (!progressBar) return;
    const { scrollTop } = getScrollState();
    if (scrollTop > 100) {
      if (!progressBar.classList.contains('visible')) {
        progressBar.classList.add('visible');
      }
    } else {
      if (progressBar.classList.contains('visible')) {
        progressBar.classList.remove('visible');
      }
    }
  };

  bindScroll(() => {
    updateScrollProgress();
    toggleProgressVisibility();
  });

  /* -------------------------------------------------------------------------- */
  /*                              HEADER CONTROLS                               */
  /* -------------------------------------------------------------------------- */

  // Language Controls
  const langWrapper = document.getElementById('lang-dropdown-wrapper');
  const langBtn = document.getElementById('lang-btn') || document.getElementById('lang-toggle');
  const mobileLangBtn = document.getElementById('mobile-lang-toggle');
  const langItems = document.querySelectorAll('.lang-item');
  const langs = ['AZ', 'EN', 'RU'];
  let currentLang = (langBtn?.dataset.currentLang
    || mobileLangBtn?.dataset.currentLang
    || langBtn?.innerText
    || mobileLangBtn?.innerText
    || 'AZ').toUpperCase();
  let langIdx = langs.indexOf(currentLang);
  if (langIdx < 0) langIdx = 0;

  const hasLangDropdown = Boolean(langWrapper && langBtn && langItems.length);
  const getLangChangeUrl = () => langBtn?.dataset.langChangeUrl || mobileLangBtn?.dataset.langChangeUrl;
  const goToLang = (lang) => {
    const urlTemplate = getLangChangeUrl();
    if (lang && urlTemplate) {
      const next = String(lang).toLowerCase();
      window.location.href = urlTemplate.replace('%3Alang', next).replace(':lang', next);
    }
  };

  if (hasLangDropdown) {
    langBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      langWrapper.classList.toggle('active');
    });

    document.addEventListener('click', (e) => {
      if (!langWrapper.contains(e.target)) {
        langWrapper.classList.remove('active');
      }
    });

    langItems.forEach(item => {
      item.addEventListener('click', () => {
        goToLang(item.dataset.lang);
      });
    });
  }

  // Ensure visibility toggle works even if Lenis fails
  if (progressBar) {
    updateScrollProgress();
    window.addEventListener('resize', updateScrollProgress);
  }

  // AOS Initialization
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 800,
      easing: 'ease-out-cubic',
      once: true,
      offset: 50
    });
  }
  const translations = {
    AZ: {
      hero_title: 'Qlobal İnnovasiya <br> Və Süni Zəka',
      hero_desc: 'Biznesinizi gələcəyə daşımaq üçün strategiya, dizayn və texnologiyanı birləşdiririk.',
      btn_start: 'Başla',
      btn_works: 'İşlərimiz',
      nav_home: 'Ana səhifə',
      nav_services: 'Xidmətlər',
      nav_portfolio: 'Portfel',
      nav_about: 'Haqqımızda',
      nav_blog: 'Bloq',
      nav_contact: 'Əlaqə',
      read_more: 'Ətraflı',
      sec_services_title: 'Biz nə edirik?',
      sec_services_sub: 'Biznesinizi böyütmək üçün kompleks həllər',
      sec_process_title: 'Necə işləyirik?',
      sec_process_sub: 'Uğura aparan 4 addım',
      sec_team_title: 'Komandamız',
      sec_team_sub: 'Biznesinizin arxasındakı yaradıcı güc',
      est_title: 'Ağıllı qiymət hesablayıcı',
      est_sub: 'Layihənizin büdcəsini təxmin edin',
      est_urgency_slow: 'Yavaş',
      est_urgency_normal: 'Normal',
      est_urgency_urgent: 'Təcili',
      est_select_service: 'Xidmət seçin',
      btn_view_all: 'Bütün layihələrə bax',
      magnet_title: 'Pulsuz vebsayt auditi',
      magnet_desc: 'Saytınızın performansını və SEO vəziyyətini pulsuz yoxlayın.',
      btn_audit: 'Auditi başlat',
      sec_contact_title: 'Layihənizi bizimlə başladın',
      btn_submit: 'Göndər',
      ph_name: 'Adınız və soyadınız',
      ph_email: 'Email ünvanınız',
      ph_phone: 'Telefon nömrəniz',
      ph_msg: 'Layihə haqqında qısa məlumat',
      ph_company: 'Şirkət adı',
      search_placeholder: 'AI axtarış...',
      ai_placeholder: 'Sual verin...',
      form_sending: 'Göndərilir...',
      form_success: 'Uğurla göndərildi!',
      form_error: 'Xəta baş verdi. Zəhmət olmasa yenidən yoxlayın.',
      ai_disabled: 'AI hazırda deaktivdir',
      ai_no_response: 'Cavab alınmadı.',
      ai_offline: 'AI hazırda aktiv deyil.',
      footer_desc: 'Biznesinizi gələcəyə daşıyan qlobal innovasiya agentliyi.',
      'preview.cookie.text': 'Təcrübənizi yaxşılaşdırmaq üçün kukilərdən istifadə edirik.',
      'preview.cookie.settings': 'Cookie ayarları',
      'preview.cookie.essential': 'Vacib kukilər',
      'preview.cookie.essential_desc': 'Saytın işləməsi üçün lazımdır.',
      'preview.cookie.analytics': 'Analitika kukiləri',
      'preview.cookie.analytics_desc': 'İstifadə və trafiki analiz etməyə kömək edir.',
      'preview.cookie.marketing': 'Marketinq kukiləri',
      'preview.cookie.marketing_desc': 'Reklam performansının ölçülməsinə kömək edir.',
      'preview.cookie.policy_title': 'Cookie siyasəti',
      'preview.cookie.policy_analytics': 'Analitika kukiləri trafiki və istifadənin ölçülməsini edir.',
      'preview.cookie.policy_marketing': 'Marketinq kukiləri reklamların ölçülməsinə kömək edir.',
      'preview.cookie.policy_theme': 'Tema kukisi görünüş seçiminizi yadda saxlayır.',
      'preview.cookie.save': 'Yadda saxla',
      'preview.cookie.accept_all': 'Hamısını qəbul et',
      'preview.cookie.decline': 'Rədd et',
      'front.cookie.text': 'Təcrübənizi yaxşılaşdırmaq üçün kukilərdən istifadə edirik.',
      'front.cookie.settings': 'Cookie ayarları',
      'front.cookie.essential': 'Vacib kukilər',
      'front.cookie.essential_desc': 'Saytın işləməsi üçün lazımdır.',
      'front.cookie.analytics': 'Analitika kukiləri',
      'front.cookie.analytics_desc': 'İstifadə və trafiki analiz etməyə kömək edir.',
      'front.cookie.marketing': 'Marketinq kukiləri',
      'front.cookie.marketing_desc': 'Reklam performansının ölçülməsinə kömək edir.',
      'front.cookie.policy_title': 'Cookie siyasəti',
      'front.cookie.policy_analytics': 'Analitika kukiləri trafiki və istifadənin ölçülməsini edir.',
      'front.cookie.policy_marketing': 'Marketinq kukiləri reklamların ölçülməsinə kömək edir.',
      'front.cookie.policy_theme': 'Tema kukisi görünüş seçiminizi yadda saxlayır.',
      'front.cookie.save': 'Yadda saxla',
      'front.cookie.accept_all': 'Hamısını qəbul et',
      'front.cookie.decline': 'Rədd et',
    },
    EN: {
      hero_title: 'Global Innovation <br> And Artificial Intelligence',
      hero_desc: 'We combine strategy, design, and technology to move your business forward.',
      btn_start: 'Start',
      btn_works: 'Our Work',
      nav_home: 'Home',
      nav_services: 'Services',
      nav_portfolio: 'Portfolio',
      nav_about: 'About',
      nav_blog: 'Blog',
      nav_contact: 'Contact',
      read_more: 'Read more',
      sec_services_title: 'What We Do',
      sec_services_sub: 'Complex solutions to grow your business',
      sec_process_title: 'How We Work',
      sec_process_sub: '4 steps to success',
      sec_team_title: 'Our Team',
      sec_team_sub: 'The creative force behind your business',
      est_title: 'Smart pricing estimator',
      est_sub: 'Estimate your project budget',
      est_urgency_slow: 'Slow',
      est_urgency_normal: 'Standard',
      est_urgency_urgent: 'Urgent',
      est_select_service: 'Select a service',
      btn_view_all: 'View all projects',
      magnet_title: 'Free website audit',
      magnet_desc: 'Check your site\'s performance and SEO for free.',
      btn_audit: 'Start audit',
      sec_contact_title: 'Start your project with us',
      btn_submit: 'Send',
      ph_name: 'Full name',
      ph_email: 'Email address',
      ph_phone: 'Phone number',
      ph_msg: 'Briefly describe your project',
      ph_company: 'Company name',
      search_placeholder: 'AI Search...',
      ai_placeholder: 'Ask a question...',
      form_sending: 'Sending...',
      form_success: 'Sent successfully!',
      form_error: 'An error occurred. Please check and try again.',
      ai_disabled: 'AI is currently disabled',
      ai_no_response: 'No response received.',
      ai_offline: 'AI is not active right now.',
      footer_desc: 'A global innovation agency moving your business forward.',
      'preview.cookie.text': 'We use cookies to improve your experience.',
      'preview.cookie.settings': 'Cookie settings',
      'preview.cookie.essential': 'Essential cookies',
      'preview.cookie.essential_desc': 'Required for the site to work.',
      'preview.cookie.analytics': 'Analytics cookies',
      'preview.cookie.analytics_desc': 'Helps us analyze usage and traffic.',
      'preview.cookie.marketing': 'Marketing cookies',
      'preview.cookie.marketing_desc': 'Helps measure advertising performance.',
      'preview.cookie.policy_title': 'Cookie policy',
      'preview.cookie.policy_analytics': 'Analytics cookies measure traffic and usage.',
      'preview.cookie.policy_marketing': 'Marketing cookies help measure advertising performance.',
      'preview.cookie.policy_theme': 'Theme cookie stores your display preference.',
      'preview.cookie.save': 'Save',
      'preview.cookie.accept_all': 'Accept all',
      'preview.cookie.decline': 'Decline',
      'front.cookie.text': 'We use cookies to improve your experience.',
      'front.cookie.settings': 'Cookie settings',
      'front.cookie.essential': 'Essential cookies',
      'front.cookie.essential_desc': 'Required for the site to work.',
      'front.cookie.analytics': 'Analytics cookies',
      'front.cookie.analytics_desc': 'Helps us analyze usage and traffic.',
      'front.cookie.marketing': 'Marketing cookies',
      'front.cookie.marketing_desc': 'Helps measure advertising performance.',
      'front.cookie.policy_title': 'Cookie policy',
      'front.cookie.policy_analytics': 'Analytics cookies measure traffic and usage.',
      'front.cookie.policy_marketing': 'Marketing cookies help measure advertising performance.',
      'front.cookie.policy_theme': 'Theme cookie stores your display preference.',
      'front.cookie.save': 'Save',
      'front.cookie.accept_all': 'Accept all',
      'front.cookie.decline': 'Decline',
    },
    RU: {
      hero_title: 'Глобальные инновации <br> и искусственный интеллект',
      hero_desc: 'Мы объединяем стратегию, дизайн и технологии, чтобы развивать ваш бизнес.',
      btn_start: 'Начать',
      btn_works: 'Наши работы',
      nav_home: 'Главная',
      nav_services: 'Услуги',
      nav_portfolio: 'Портфолио',
      nav_about: 'О нас',
      nav_blog: 'Блог',
      nav_contact: 'Контакты',
      read_more: 'Читать дальше',
      sec_services_title: 'Что мы делаем',
      sec_services_sub: 'Комплексные решения для роста вашего бизнеса',
      sec_process_title: 'Как мы работаем',
      sec_process_sub: '4 шага к успеху',
      sec_team_title: 'Наша команда',
      sec_team_sub: 'Креативная сила, стоящая за вашим бизнесом',
      est_title: 'Умный калькулятор стоимости',
      est_sub: 'Оцените бюджет проекта',
      est_urgency_slow: 'Медленно',
      est_urgency_normal: 'Обычный',
      est_urgency_urgent: 'Срочно',
      est_select_service: 'Выберите услугу',
      btn_view_all: 'Посмотреть все проекты',
      magnet_title: 'Бесплатный аудит сайта',
      magnet_desc: 'Бесплатно проверьте производительность сайта и SEO.',
      btn_audit: 'Начать аудит',
      sec_contact_title: 'Запустите проект вместе с нами',
      btn_submit: 'Отправить',
      ph_name: 'Имя и фамилия',
      ph_email: 'Email адрес',
      ph_phone: 'Номер телефона',
      ph_msg: 'Кратко опишите проект',
      ph_company: 'Название компании',
      search_placeholder: 'AI‑поиск...',
      ai_placeholder: 'Задайте вопрос...',
      form_sending: 'Отправляется...',
      form_success: 'Успешно отправлено!',
      form_error: 'Произошла ошибка. Проверьте и попробуйте снова.',
      ai_disabled: 'AI сейчас отключен',
      ai_no_response: 'Ответ не получен.',
      ai_offline: 'AI сейчас не активен.',
      footer_desc: 'Агентство глобальных инноваций, которое развивает ваш бизнес.',
      'preview.cookie.text': 'Мы используем cookie для улучшения вашего опыта.',
      'preview.cookie.settings': 'Настройки cookie',
      'preview.cookie.essential': 'Обязательные cookie',
      'preview.cookie.essential_desc': 'Нужны для работы сайта.',
      'preview.cookie.analytics': 'Аналитические cookie',
      'preview.cookie.analytics_desc': 'Помогают анализировать использование и трафик.',
      'preview.cookie.marketing': 'Маркетинговые cookie',
      'preview.cookie.marketing_desc': 'Помогают измерять эффективность рекламы.',
      'preview.cookie.policy_title': 'Политика cookie',
      'preview.cookie.policy_analytics': 'Аналитические cookie измеряют трафик и использование.',
      'preview.cookie.policy_marketing': 'Маркетинговые cookie помогают измерять эффективность рекламы.',
      'preview.cookie.policy_theme': 'Cookie темы сохраняет ваш выбор оформления.',
      'preview.cookie.save': 'Сохранить',
      'preview.cookie.accept_all': 'Принять все',
      'preview.cookie.decline': 'Отклонить',
      'front.cookie.text': 'Мы используем cookie для улучшения вашего опыта.',
      'front.cookie.settings': 'Настройки cookie',
      'front.cookie.essential': 'Обязательные cookie',
      'front.cookie.essential_desc': 'Нужны для работы сайта.',
      'front.cookie.analytics': 'Аналитические cookie',
      'front.cookie.analytics_desc': 'Помогают анализировать использование и трафик.',
      'front.cookie.marketing': 'Маркетинговые cookie',
      'front.cookie.marketing_desc': 'Помогают измерять эффективность рекламы.',
      'front.cookie.policy_title': 'Политика cookie',
      'front.cookie.policy_analytics': 'Аналитические cookie измеряют трафик и использование.',
      'front.cookie.policy_marketing': 'Маркетинговые cookie помогают измерять эффективность рекламы.',
      'front.cookie.policy_theme': 'Cookie темы сохраняет ваш выбор оформления.',
      'front.cookie.save': 'Сохранить',
      'front.cookie.accept_all': 'Принять все',
      'front.cookie.decline': 'Отклонить',
    }
  };
  const getTranslation = (key, fallback = '') => {
    const data = translations[currentLang] || translations.AZ || {};
    return data[key] || fallback;
  };
  function applyLang(lang) {
    currentLang = lang;
    if (langBtn) langBtn.innerText = currentLang;
    if (mobileLangBtn) mobileLangBtn.innerText = currentLang;
    const data = translations[currentLang] || translations.AZ || {};
    document.querySelectorAll('[data-lang]').forEach(el => {
      const key = el.getAttribute('data-lang');
      if (data[key]) {
        if (key.startsWith('nav_')) {
          const icon = el.querySelector('svg') ? el.querySelector('svg').outerHTML : '';
          const span = el.querySelector('span');
          if (span) span.innerText = data[key];
          else el.innerHTML = icon + ' <span>' + data[key] + '</span>';
        } else if (key === 'btn_start' || key === 'read_more') {
          const icon = el.querySelector('svg') ? el.querySelector('svg').outerHTML : '';
          el.innerHTML = data[key] + ' ' + icon;
        } else {
          el.innerHTML = data[key];
        }
      }
    });
    document.querySelectorAll('[data-lang-placeholder]').forEach(el => {
      const key = el.getAttribute('data-lang-placeholder');
      if (data[key]) {
        el.setAttribute('placeholder', data[key]);
      }
    });
  }
  function updateLang() {
    langIdx = (langIdx + 1) % langs.length;
    applyLang(langs[langIdx]);
    goToLang(currentLang);
  }
  applyLang(currentLang);
  if (langBtn && !hasLangDropdown) langBtn.addEventListener('click', updateLang);
  if (mobileLangBtn) mobileLangBtn.addEventListener('click', updateLang);

  const mobileToggle = document.getElementById('mobile-menu-toggle');
  const closeMenu = document.getElementById('close-menu');
  const mobileNav = document.getElementById('mobile-nav');
  const setMobileExpanded = (state) => mobileToggle?.setAttribute('aria-expanded', String(state));
  const setBodyLock = (lock) => { document.body.style.overflow = lock ? 'hidden' : ''; };
  if (mobileToggle) mobileToggle.addEventListener('click', () => { mobileNav.classList.add('open'); setMobileExpanded(true); setBodyLock(true); });
  if (closeMenu) closeMenu.addEventListener('click', () => { mobileNav.classList.remove('open'); setMobileExpanded(false); setBodyLock(false); });
  document.addEventListener('keyup', (e) => {
    if (e.key === 'Escape' && mobileNav?.classList.contains('open')) {
      mobileNav.classList.remove('open');
      setMobileExpanded(false);
      setBodyLock(false);
    }
  });

  const searchToggle = document.getElementById('search-toggle');
  const searchOverlay = document.getElementById('search-overlay');
  const searchClose = document.getElementById('search-close');
  const searchInput = document.getElementById('search-input');
  function toggleSearch() {
    if (!searchOverlay) return;
    searchOverlay.classList.toggle('active');
    searchToggle?.setAttribute('aria-expanded', String(searchOverlay.classList.contains('active')));
    document.body.style.overflow = searchOverlay.classList.contains('active') ? 'hidden' : '';
    if (searchOverlay.classList.contains('active')) setTimeout(() => searchInput?.focus(), 100);
  }
  if (searchToggle && searchOverlay) searchToggle.addEventListener('click', toggleSearch);
  if (searchClose && searchOverlay) searchClose.addEventListener('click', toggleSearch);
  if (searchOverlay) {
    searchOverlay.addEventListener('click', (e) => {
      if (e.target === searchOverlay) toggleSearch();
    });
  }
  document.addEventListener('keyup', (e) => {
    if (e.key === 'Escape' && searchOverlay?.classList.contains('active')) toggleSearch();
  });

  const aiTrigger = document.getElementById('ai-trigger');
  const aiModal = document.getElementById('ai-modal');
  const aiClose = document.getElementById('ai-close');
  const aiSend = document.getElementById('ai-send');
  const aiInput = document.getElementById('ai-input');
  const aiBody = document.getElementById('ai-body');
  const typingIndicator = document.getElementById('typing-indicator');
  if (aiTrigger) aiTrigger.addEventListener('click', () => aiModal.classList.toggle('active'));
  if (aiClose) aiClose.addEventListener('click', () => aiModal.classList.remove('active'));
  if (aiSend && !enableAi) {
    aiSend.disabled = true;
    aiSend.title = getTranslation('ai_disabled', 'AI is currently disabled');
  }

  async function callGemini(prompt) {
    const userMsg = document.createElement('div');
    userMsg.className = 'user-message';
    userMsg.innerText = prompt;
    aiBody.appendChild(userMsg);
    aiInput.value = '';
    aiBody.scrollTop = aiBody.scrollHeight;
    typingIndicator.style.display = 'block';
    try {
      if (!enableAi) {
        throw new Error('AI disabled: provide backend proxy/apiKey.');
      }
      const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=${apiKey}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ contents: [{ parts: [{ text: `User asks: ${prompt}. Answer briefly as Chalang Agency consultant.` }] }] })
      });
      const data = await response.json();
      const aiText = data?.candidates?.[0]?.content?.parts?.[0]?.text || getTranslation('ai_no_response', 'No response received.');
      const aiMsg = document.createElement('div');
      aiMsg.className = 'ai-message';
      aiMsg.innerText = aiText;
      aiBody.appendChild(aiMsg);
    } catch (e) {
      const fallback = document.createElement('div');
      fallback.className = 'ai-message';
      fallback.innerText = getTranslation('ai_offline', 'AI is not active right now.');
      aiBody.appendChild(fallback);
      console.error(e);
    } finally {
      typingIndicator.style.display = 'none';
      aiBody.scrollTop = aiBody.scrollHeight;
    }
  }
  if (aiSend) aiSend.addEventListener('click', () => { if (aiInput.value) callGemini(aiInput.value); });
  if (aiInput) aiInput.addEventListener('keypress', (e) => { if (e.key === 'Enter' && aiInput.value) callGemini(aiInput.value); });

  if (!prefersReducedMotion && !isNarrow()) {
    if (typeof $.fn.tilt !== 'undefined') {
      $('[data-tilt]').tilt({
        maxTilt: 15,
        perspective: 1000,
        easing: "cubic-bezier(.03,.98,.52,.99)",
        speed: 500,
        glare: true,
        maxGlare: 0.2,
        scale: 1.02
      });
    }
  } else {
    $('[data-tilt]').css('transform', 'none');
  }

  const canvas = document.getElementById('hero-canvas');
  const heroSection = document.querySelector('.hero');
  if (canvas && heroSection && !prefersReducedMotion) { // Removed !isNarrow() to enabled on mobile
    const ctx = canvas.getContext('2d');
    let particlesArray = [];
    let ambientParticlesArray = [];
    const mouse = { x: null, y: null, radius: 150 };

    heroSection.addEventListener('mousemove', (event) => {
      const rect = canvas.getBoundingClientRect();
      mouse.x = event.clientX - rect.left;
      mouse.y = event.clientY - rect.top;
    });
    heroSection.addEventListener('mouseleave', () => {
      mouse.x = undefined;
      mouse.y = undefined;
    });

    function resizeCanvas() {
      const container = document.querySelector('.hero-visual');
      if (!container) return;
      canvas.width = container.clientWidth;
      canvas.height = container.clientHeight;
    }

    function initLogoMap() {
      particlesArray = [];
      ambientParticlesArray = [];
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      const scale = Math.min(canvas.width, canvas.height) / 22;
      const offsetX = (canvas.width - (16.44 * scale)) / 2;
      const offsetY = (canvas.height - (15.74 * scale)) / 2;
      const path1 = new Path2D('M8.88.03C3.91-.37-.27,3.73.01,8.7c.18,3.15,2.14,5.82,4.88,7.04.02,0,.04-.02.03-.03-.22-.3-.35-.68-.35-1.08,0-.87.6-1.6,1.41-1.8.02,0,.02-.03,0-.04-1.88-.92-3.1-2.96-2.8-5.26.27-2.08,2.21-4.04,4.29-4.34,3.14-.44,5.82,1.98,5.82,5.03,0,2-1.16,3.74-2.85,4.56-.02,0-.02.04,0,.04.81.2,1.41.93,1.41,1.8,0,.4-.13.77-.34,1.08-.01.02,0,.04.03.03,2.88-1.28,4.89-4.16,4.89-7.52C16.44,3.9,13.11.36,8.88.03Z');
      const path2 = new Path2D('M8.23,13.3l.19.37c.14.28.36.5.64.64l.37.19s.01.02,0,.03l-.37.19c-.28.14-.5.36-.64.64l-.19.37s-.02.01-.03,0l-.19-.37c-.14-.28-.36-.5-.64-.64l-.37-.19s-.01-.02,0-.03l.37-.19c.28-.14.5-.36.64-.64l.19-.37s.02-.01.03,0Z');
      ctx.save();
      ctx.translate(offsetX, offsetY);
      ctx.scale(scale, scale);
      ctx.fillStyle = 'white';
      ctx.fill(path1);
      ctx.restore();
      let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      for (let y = 0; y < canvas.height; y += 6) {
        for (let x = 0; x < canvas.width; x += 6) {
          if (imageData.data[(y * 4 * imageData.width) + (x * 4) + 3] > 128) {
            particlesArray.push(new Particle(x, y, false));
          }
        }
      }
      ctx.save();
      ctx.translate(offsetX, offsetY);
      ctx.scale(scale, scale);
      ctx.fillStyle = 'white';
      ctx.fill(path2);
      ctx.restore();
      imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      for (let y = 0; y < canvas.height; y += 3) {
        for (let x = 0; x < canvas.width; x += 3) {
          if (imageData.data[(y * 4 * imageData.width) + (x * 4) + 3] > 128) {
            particlesArray.push(new Particle(x, y, true));
          }
        }
      }
      for (let i = 0; i < 60; i++) ambientParticlesArray.push(new AmbientParticle());
    }

    window.addEventListener('resize', () => {
      resizeCanvas();
      initLogoMap();
    });
    setTimeout(() => {
      resizeCanvas();
      initLogoMap();
    }, 50);

    class Particle {
      constructor(x, y, isStar) {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.baseX = x;
        this.baseY = y;
        this.isStar = isStar;
        this.size = isStar ? 1.5 : 2;
        this.density = (Math.random() * 30) + 1;
        this.color = isStar ? '#d500f9' : '#4b0082';
        this.alpha = 0;
        this.angle = Math.random() * 360;
      }
      update() {
        const dx = (mouse.x ?? this.x) - this.x;
        const dy = (mouse.y ?? this.y) - this.y;
        const distance = Math.sqrt(dx * dx + dy * dy);
        const forceDirectionX = distance ? dx / distance : 0;
        const forceDirectionY = distance ? dy / distance : 0;
        const force = (mouse.radius - distance) / mouse.radius;
        const directionX = forceDirectionX * force * this.density;
        const directionY = forceDirectionY * force * this.density;
        if (distance < mouse.radius) {
          this.x -= directionX;
          this.y -= directionY;
          this.alpha = 1;
        } else {
          if (this.x !== this.baseX) {
            const dx2 = this.x - this.baseX;
            this.x -= dx2 / 20;
          }
          if (this.y !== this.baseY) {
            const dy2 = this.y - this.baseY;
            this.y -= dy2 / 20;
          }
          this.x += Math.sin(this.angle) * 0.1;
          this.y += Math.cos(this.angle) * 0.1;
          this.angle += 0.05;
          if (this.alpha < 1) this.alpha += 0.02;
        }
      }
      draw() {
        ctx.globalAlpha = this.alpha;
        ctx.fillStyle = this.color;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.closePath();
        ctx.fill();
        ctx.globalAlpha = 1;
      }
    }

    class AmbientParticle {
      constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.size = Math.random() * 2 + 0.5;
        this.speedX = (Math.random() * 0.5) - 0.25;
        this.speedY = (Math.random() * 0.5) - 0.25;
        this.color = Math.random() > 0.5 ? 'rgba(75, 0, 130, 0.2)' : 'rgba(213, 0, 249, 0.2)';
      }
      update() {
        this.x += this.speedX;
        this.y += this.speedY;
        if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
        if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
      }
      draw() {
        ctx.fillStyle = this.color;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fill();
      }
    }

    function connect() {
      for (let a = 0; a < particlesArray.length; a++) {
        if (!particlesArray[a].isStar && a % 3 !== 0) continue;
        for (let b = a; b < particlesArray.length; b++) {
          const dx = particlesArray[a].x - particlesArray[b].x;
          const dy = particlesArray[a].y - particlesArray[b].y;
          const distance = dx * dx + dy * dy;
          const connectDist = particlesArray[a].isStar ? 400 : 600;
          if (distance < connectDist) {
            ctx.globalAlpha = particlesArray[a].alpha * (particlesArray[a].isStar ? 0.6 : 0.3);
            ctx.strokeStyle = particlesArray[a].isStar ? 'rgba(213, 0, 249, 0.5)' : 'rgba(75, 0, 130, 0.4)';
            ctx.lineWidth = 0.8;
            ctx.beginPath();
            ctx.moveTo(particlesArray[a].x, particlesArray[a].y);
            ctx.lineTo(particlesArray[b].x, particlesArray[b].y);
            ctx.stroke();
            ctx.globalAlpha = 1;
          }
        }
      }
      for (let i = 0; i < ambientParticlesArray.length; i++) {
        for (let j = 0; j < particlesArray.length; j += 15) {
          const dx = ambientParticlesArray[i].x - particlesArray[j].x;
          const dy = ambientParticlesArray[i].y - particlesArray[j].y;
          const dist = dx * dx + dy * dy;
          if (dist < 3000) {
            ctx.strokeStyle = 'rgba(213, 0, 249, 0.1)';
            ctx.lineWidth = 0.2;
            ctx.beginPath();
            ctx.moveTo(ambientParticlesArray[i].x, ambientParticlesArray[i].y);
            ctx.lineTo(particlesArray[j].x, particlesArray[j].y);
            ctx.stroke();
          }
        }
      }
    }

    function animate() {
      requestAnimationFrame(animate);
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      for (let i = 0; i < particlesArray.length; i++) {
        particlesArray[i].update();
        particlesArray[i].draw();
      }
      for (let i = 0; i < ambientParticlesArray.length; i++) {
        ambientParticlesArray[i].update();
        ambientParticlesArray[i].draw();
      }
      connect();
    }
    animate();


  }


  // Isotope Initialization for Portfolio
  const isotopeContainer = document.querySelector('.axil-isotope-wrapper');
  if (isotopeContainer && window.Isotope) {
    const isotopeList = isotopeContainer.querySelector('.isotope-list');
    const filterButtons = isotopeContainer.querySelectorAll('.filter-btn');

    if (isotopeList) {
      const iso = new Isotope(isotopeList, {
        itemSelector: '.project',
        layoutMode: 'fitRows',
        transitionDuration: '0.7s',
        stagger: 30
      });

      if (window.imagesLoaded) {
        imagesLoaded(isotopeList, () => iso.layout());
      }

      filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
          const filterValue = btn.getAttribute('data-filter');
          iso.arrange({ filter: filterValue });

          filterButtons.forEach(b => b.classList.remove('is-checked'));
          btn.classList.add('is-checked');
        });
      });
    }
  }

  // Magnific Popup Initialization
  if (typeof $.fn.magnificPopup !== 'undefined') {
    $('.popup-zoom').magnificPopup({
      type: 'image',
      mainClass: 'mfp-with-zoom',
      gallery: {
        enabled: true
      },
      zoom: {
        enabled: true,
        duration: 300,
        easing: 'ease-in-out'
      }
    });

    $('.popup-youtube, .popup-vimeo, .popup-gmaps, .popup-video').magnificPopup({
      disableOn: 700,
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 160,
      preloader: false,
      fixedContentPos: false
    });
  }

  // FAQ Accordion Logic
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    item.addEventListener('click', () => {
      const isActive = item.classList.contains('active');

      // Close all other items
      faqItems.forEach(otherItem => {
        if (otherItem !== item) {
          otherItem.classList.remove('active');
        }
      });

      // Toggle current item
      item.classList.toggle('active', !isActive);
    });
  });

  // Handle Switcher Clicks
  $(document).on('click', '.setColor', function () {
    const theme = $(this).data('theme');
    applyTheme(theme);
  });
  // AJAX Form Submission Handler
  $('form').on('submit', function (e) {
    const $form = $(this);
    const action = $form.attr('action');

    // Only handle contact/order/call/subscribe forms
    if (this.id === 'audit-form') return; // SEPARATE HANDLER IN BLADE

    if (action && (action.includes('contact') || action.includes('order') || action.includes('call') || action.includes('subscribe'))) {
      e.preventDefault();

      const $btn = $form.find('button[type="submit"]');
      const originalBtnText = $btn.html();

      // Basic loading state
      $btn.prop('disabled', true).html('<span class="spinner"></span> ' + getTranslation('form_sending', 'Sending...'));

      $.ajax({
        url: action,
        method: 'POST',
        data: $form.serialize(),
        dataType: 'json',
        success: function (response) {
          showNotification(response.message || getTranslation('form_success', 'Sent successfully!'), 'success');
          $form[0].reset();
        },
        error: function (xhr) {
          const errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
          let errorMessage = getTranslation('form_error', 'An error occurred. Please check and try again.');

          if (errors) {
            errorMessage = Object.values(errors).flat().join('<br>');
          } else if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }

          showNotification(errorMessage, 'error');
        },
        complete: function () {
          $btn.prop('disabled', false).html(originalBtnText);
        }
      });
    }
  });

  // Glassmorphism Notification System
  function showNotification(message, type = 'success') {
    const $notif = $(`
      <div class="glass-notification ${type}">
        <div class="notif-content">${message}</div>
        <div class="notif-progress"></div>
      </div>
    `);

    $('body').append($notif);

    setTimeout(() => $notif.addClass('show'), 100);

    setTimeout(() => {
      $notif.removeClass('show');
      setTimeout(() => $notif.remove(), 500);
    }, 5000);
  }

  // Slick Slider Initialization
  const hasSlick = typeof $.fn.slick === 'function';
  if (hasSlick) {
    if ($('.partner-slider').length) {
      $('.partner-slider').slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        arrows: false,
        dots: false,
        autoplay: true,
        autoplaySpeed: 3000,
        speed: 1000,
        responsive: [
          { breakpoint: 1200, settings: { slidesToShow: 4 } },
          { breakpoint: 992, settings: { slidesToShow: 3 } },
          { breakpoint: 768, settings: { slidesToShow: 2 } },
          { breakpoint: 480, settings: { slidesToShow: 2 } }
        ]
      });
    }

    // TESTIMONIALS SLIDER
    if ($('.testimonial-slider').length) {
      $('.testimonial-slider').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: false,
        dots: true,
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 800,
        responsive: [
          { breakpoint: 992, settings: { slidesToShow: 2 } },
          { breakpoint: 768, settings: { slidesToShow: 1 } }
        ]
      });
    }

    // BLOG SLIDER
    if ($('.blog-slider').length) {
      $('.blog-slider').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        autoplay: false,
        responsive: [
          { breakpoint: 992, settings: { slidesToShow: 2 } },
          { breakpoint: 768, settings: { slidesToShow: 1, arrows: false, dots: true } }
        ]
      });
    }

    /* -------------------------------------------------------------------------- */
    /*                       MOBILE SLIDERS (Services, Team, Portfolio)           */
    /* -------------------------------------------------------------------------- */
    const mobileSliderSettings = {
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      dots: true,
      autoplay: true,
      autoplaySpeed: 3000,
      centerMode: true,
      centerPadding: '20px',
      variableWidth: false
    };

    const initMobileSliders = () => {
      // Breakpoint: 991px (below 992)
      const isMobile = window.matchMedia('(max-width: 991px)').matches;
      const sliders = ['.services-grid-2', '.team-grid', '.portfolio-grid'];

      sliders.forEach(selector => {
        const $el = $(selector);
        if ($el.length) {
          if (isMobile && !$el.hasClass('slick-initialized')) {
            $el.slick(mobileSliderSettings);
            $el.addClass('mobile-slider-active'); // Helper class for CSS
          } else if (!isMobile && $el.hasClass('slick-initialized')) {
            $el.slick('unslick');
            $el.removeClass('mobile-slider-active');
          }
        }
      });
    };

    // Run on load and resize
    initMobileSliders();
    let resizeTimer;
    $(window).on('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(initMobileSliders, 250);
    });
  }

  // PRELOADER
  const preloader = document.getElementById("preloader-wrapper");
  const preloaderProgress = document.querySelector(".loader-progress");

  if (preloader) {
    // Counter Animation
    let count = 0;
    const progressInterval = setInterval(() => {
      count++;
      if (preloaderProgress) preloaderProgress.innerText = count + '%';
      if (count >= 100) clearInterval(progressInterval);
    }, 20); // 2s total duration approx

    window.hidePreloader = () => {
      clearInterval(progressInterval);
      if (preloaderProgress) preloaderProgress.innerText = '100%';

      document.body.classList.add('loaded');
      preloader.style.opacity = "0";
      setTimeout(() => { preloader.style.display = "none"; }, 800);
    };

    window.addEventListener('load', window.hidePreloader);
  }

  /* -------------------------------------------------------------------------- */
  /*                            Back to Top (Circular)                          */
  /* -------------------------------------------------------------------------- */
  // Logic moved to end of file to ensure execution independent of main try/catch block errors.


  /* -------------------------------------------------------------------------- */
  /*                              Counter Animation                             */
  /* -------------------------------------------------------------------------- */
  const initCounters = () => {
    const counters = document.querySelectorAll('.counter');
    if (!counters.length) return;

    const animateCounter = (el) => {
      // Remove any non-numeric chars (except maybe . if needed, but usually integers)
      // If the text is "10+" -> target is 10
      const rawText = el.innerText;
      const target = parseInt(rawText.replace(/[^\d]/g, ''), 10);

      if (isNaN(target)) return;

      const duration = 2000; // 2 seconds
      const frameDuration = 1000 / 60; // 60fps
      const totalFrames = Math.round(duration / frameDuration);
      const easeOutQuad = (t) => t * (2 - t);

      let frame = 0;

      const updateCount = () => {
        frame++;
        const progress = easeOutQuad(frame / totalFrames);
        const currentCount = Math.round(target * progress);

        if (frame < totalFrames) {
          el.innerText = currentCount;
          requestAnimationFrame(updateCount);
        } else {
          el.innerText = target;
        }
      };

      updateCount();
      el.classList.add('can-animate');
    };

    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const el = entry.target;
          if (!el.classList.contains('can-animate')) {
            animateCounter(el);
          }
          observer.unobserve(el);
        }
      });
    }, {
      threshold: 0.5
    });

    counters.forEach(counter => {
      observer.observe(counter);
    });
  };

  initCounters();

  /* -------------------------------------------------------------------------- */
  /*                              Process Tabs Logic                            */
  /* -------------------------------------------------------------------------- */
  const processSteps = document.querySelectorAll('.process-step');
  const processDetails = document.querySelectorAll('.process-detail-item');

  if (processSteps.length && processDetails.length) {
    const updateProgress = (stepIndex) => {
      const total = processSteps.length;
      const line = document.querySelector('.process-line');
      if (!line || total <= 1) {
        return;
      }
      const progress = ((stepIndex - 1) / (total - 1)) * 100;
      line.style.background = `linear-gradient(90deg, var(--brand-primary) ${progress}%, rgba(var(--brand-primary-rgb), 0.2) ${progress}%)`;
    };

    const setActiveStep = (stepIndex) => {
      const target = String(stepIndex);
      processSteps.forEach(step => {
        step.classList.toggle('active', step.getAttribute('data-step') === target);
      });
      processDetails.forEach(detail => {
        detail.classList.toggle('active', detail.getAttribute('data-step') === target);
      });
      updateProgress(Number(stepIndex));
    };

    processSteps.forEach(step => {
      step.addEventListener('click', () => {
        const stepIndex = step.getAttribute('data-step');
        if (stepIndex) {
          setActiveStep(stepIndex);
        }
      });
    });

    const initialStep = Array.from(processSteps).find(step => step.classList.contains('active'))?.getAttribute('data-step')
      || processSteps[0]?.getAttribute('data-step');
    if (initialStep) {
      setActiveStep(initialStep);
    }
  }

  // --------------------------------------------------------------------------
  // PRICE ESTIMATOR LOGIC (v2 - Currency Support)
  // --------------------------------------------------------------------------
  const estServices = document.querySelectorAll('#est-services .service-opt');
  const estSizes = document.querySelectorAll('#est-size .service-opt');
  const estTime = document.getElementById('est-time');
  const estPriceDisplay = document.getElementById('est-price');
  const currencyToggle = document.getElementById('est-currency-toggle');
  const lblUsd = document.getElementById('lbl-usd');
  const lblAzn = document.getElementById('lbl-azn');
  const estimatorSection = document.querySelector('.estimator-section');

  let currentCurrency = 'USD'; // Default
  const exchangeRate = parseFloat(estimatorSection?.getAttribute('data-exchange-rate')) || 1.7;
  const estimatorStorageKey = 'chalang_estimator_state_v1';
  const quoteModal = document.getElementById('quote-modal-overlay');
  const quoteOpenBtn = document.getElementById('est-cta');
  const quoteCloseBtn = document.getElementById('quote-modal-close');
  const quoteMessage = document.getElementById('quote-message');
  const quoteNote = document.getElementById('quote-note');
  const quoteCompany = document.getElementById('quote-company');
  const quoteSummaryRows = document.querySelectorAll('[data-summary-row]');
  const quoteForm = document.querySelector('[data-quote-form]');
  const canEstimate = estServices.length && estSizes.length && estTime && estPriceDisplay;
  const normalizeLabel = (value, fallback) => {
    if (!value) {
      return fallback;
    }
    const trimmed = String(value).trim();
    if (!trimmed || trimmed.indexOf('preview.estimator.') === 0) {
      return fallback;
    }
    return trimmed;
  };

  const urgencyLabels = {
    slow: normalizeLabel(estimatorSection?.dataset?.urgencySlow, getTranslation('est_urgency_slow', 'Slow')),
    normal: normalizeLabel(estimatorSection?.dataset?.urgencyNormal, getTranslation('est_urgency_normal', 'Standard')),
    urgent: normalizeLabel(estimatorSection?.dataset?.urgencyUrgent, getTranslation('est_urgency_urgent', 'Urgent'))
  };

  const applyCurrencyUI = () => {
    if (!lblUsd || !lblAzn) {
      return;
    }
    if (currentCurrency === 'AZN') {
      lblUsd.classList.remove('active');
      lblAzn.classList.add('active');
    } else {
      lblAzn.classList.remove('active');
      lblUsd.classList.add('active');
    }
  };

  const setCurrency = (currency, shouldRecalc = true) => {
    currentCurrency = currency === 'AZN' ? 'AZN' : 'USD';
    if (currencyToggle) {
      currencyToggle.checked = currentCurrency === 'AZN';
    }
    applyCurrencyUI();
    if (shouldRecalc && canEstimate) {
      calculateEstimate();
    }
  };

  const getEstimatorState = () => {
    const selectedService = document.querySelector('#est-services .service-opt.selected');
    const selectedSize = document.querySelector('#est-size .service-opt.selected');

    return {
      service: {
        label: selectedService ? selectedService.textContent.trim() : '',
        value: selectedService ? selectedService.getAttribute('data-val') : ''
      },
      size: {
        label: selectedSize ? selectedSize.textContent.trim() : '',
        value: selectedSize ? selectedSize.getAttribute('data-val') : ''
      },
      urgency: estTime ? parseInt(estTime.value, 10) : null,
      currency: currentCurrency,
      estimate: estPriceDisplay ? estPriceDisplay.innerText.trim() : ''
    };
  };

  const persistEstimatorState = () => {
    try {
      localStorage.setItem(estimatorStorageKey, JSON.stringify(getEstimatorState()));
    } catch (error) {
      // Storage might be unavailable, ignore silently.
    }
  };

  const applySelection = (nodes, data) => {
    if (!data || (!data.label && data.value === '')) {
      return false;
    }
    const nodesArray = Array.from(nodes);
    const valueMatch = data.value !== '' ? nodesArray.find(node => node.getAttribute('data-val') === String(data.value)) : null;
    const labelMatch = data.label
      ? nodesArray.find(node => node.textContent.trim().toLowerCase() === data.label.toLowerCase())
      : null;
    const target = valueMatch || labelMatch;

    if (!target) {
      return false;
    }
    nodesArray.forEach(node => node.classList.remove('selected'));
    target.classList.add('selected');
    return true;
  };

  const restoreEstimatorState = () => {
    try {
      const raw = localStorage.getItem(estimatorStorageKey);
      if (!raw) {
        return;
      }
      const state = JSON.parse(raw);
      if (state.service) {
        applySelection(estServices, state.service);
      }
      if (state.size) {
        applySelection(estSizes, state.size);
      }
      if (state.urgency && estTime) {
        estTime.value = Math.min(Math.max(parseInt(state.urgency, 10) || 1, 1), 3);
      }
      if (state.currency) {
        setCurrency(state.currency, false);
      }
    } catch (error) {
      // Ignore invalid stored data.
    }
  };

  const getUrgencyLabel = (value) => {
    if (!value) {
      return '-';
    }
    if (value === 1) return urgencyLabels.slow;
    if (value === 2) return urgencyLabels.normal;
    if (value === 3) return urgencyLabels.urgent;
    return String(value);
  };

  const updateQuoteModal = (forceMessage = false) => {
    if (!quoteModal) {
      return;
    }
    const state = getEstimatorState();
    const summaryValues = {
      service: state.service.label || '-',
      size: state.size.label || '-',
      urgency: getUrgencyLabel(state.urgency),
      estimate: state.estimate || '-'
    };
    const lines = [];

    quoteSummaryRows.forEach(row => {
      const key = row.getAttribute('data-summary-row');
      const label = row.querySelector('.summary-label')?.textContent?.trim() || '';
      const value = summaryValues[key] || '-';
      const valueEl = row.querySelector('[data-summary-value]');
      if (valueEl) {
        valueEl.textContent = value;
      }
      if (label) {
        lines.push(label + ': ' + value);
      }
    });

    const companyValue = quoteCompany ? quoteCompany.value.trim() : '';
    if (companyValue) {
      lines.push(getTranslation('ph_company', 'Company') + ': ' + companyValue);
    }
    const noteValue = quoteNote ? quoteNote.value.trim() : '';
    if (noteValue) {
      lines.push(getTranslation('ph_msg', 'Note') + ': ' + noteValue);
    }

    if (quoteMessage) {
      const shouldFill = forceMessage || quoteMessage.value.trim() === '';
      if (shouldFill) {
        quoteMessage.value = lines.join('\n');
      }
    }
  };

  const openQuoteModal = () => {
    updateQuoteModal(true);
    if (quoteModal) {
      quoteModal.classList.add('active');
      quoteModal.setAttribute('aria-hidden', 'false');
      document.body.classList.add('modal-open');
    }
  };

  const closeQuoteModal = () => {
    if (quoteModal) {
      quoteModal.classList.remove('active');
      quoteModal.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('modal-open');
    }
  };

  const calculateEstimate = () => {
    if (!canEstimate) {
      persistEstimatorState();
      return;
    }
    // 1. Get Base Price from selected Service
    const selectedService = document.querySelector('#est-services .service-opt.selected');
    const basePrice = selectedService ? parseFloat(selectedService.getAttribute('data-val')) : 0;

    // 2. Get Multiplier from selected Size
    const selectedSize = document.querySelector('#est-size .service-opt.selected');
    const sizeMultiplier = selectedSize ? parseFloat(selectedSize.getAttribute('data-val')) : 1;

    // 3. Get Urgency Factor (1=Slow, 2=Normal, 3=Urgent)
    const urgencyVal = parseInt(estTime.value, 10);
    const multSlow = parseFloat(estimatorSection?.dataset?.urgencyMultSlow) || 1.0;
    const multNormal = parseFloat(estimatorSection?.dataset?.urgencyMultNormal) || 1.25;
    const multUrgent = parseFloat(estimatorSection?.dataset?.urgencyMultUrgent) || 1.5;

    let urgencyFactor = multSlow;
    if (urgencyVal === 2) urgencyFactor = multNormal;
    if (urgencyVal === 3) urgencyFactor = multUrgent;

    // OLD LOGIC (Removed)
    // let urgencyFactor = 1;
    // if (urgencyVal === 2) urgencyFactor = 1.25;
    // if (urgencyVal === 3) urgencyFactor = 1.5;
    // OLD LOGIC REMOVED


    // 4. Calculate Total in USD
    let finalTotal = basePrice * sizeMultiplier * urgencyFactor;

    // 5. Convert if AZN
    if (currentCurrency === 'AZN') {
      finalTotal = finalTotal * exchangeRate;
    }

    // 6. Create a Range (+/- 20%)
    const min = Math.round(finalTotal * 0.9);
    const max = Math.round(finalTotal * 1.2);

    // 7. Format Currency
    const locale = currentCurrency === 'AZN' ? 'az-AZ' : 'en-US';
    const formatter = new Intl.NumberFormat(locale, {
      style: 'currency',
      currency: currentCurrency,
      maximumFractionDigits: 0
    });

    // 8. Update Display
    if (basePrice > 0) {
      estPriceDisplay.innerText = `${formatter.format(min)} - ${formatter.format(max)}`;
    } else {
      const selectServiceText = estimatorSection?.getAttribute('data-est-select-service') || getTranslation('est_select_service', 'Select a service');
      estPriceDisplay.innerText = selectServiceText;
    }

    persistEstimatorState();
    if (quoteModal && quoteModal.classList.contains('active')) {
      updateQuoteModal(false);
    }
  };

  // Toggle Currency
  if (currencyToggle) {
    currencyToggle.addEventListener('change', () => {
      setCurrency(currencyToggle.checked ? 'AZN' : 'USD');
    });
  }

  if (canEstimate) {
    // Event Listeners for Service Selection
    estServices.forEach(btn => {
      const selectService = () => {
        estServices.forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        calculateEstimate();
      };
      btn.addEventListener('click', selectService);
      btn.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          selectService();
        }
      });
    });

    // Event Listeners for Size Selection
    estSizes.forEach(btn => {
      const selectSize = () => {
        estSizes.forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        calculateEstimate();
      };
      btn.addEventListener('click', selectSize);
      btn.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          selectSize();
        }
      });
    });

    // Event Listener for Time Slider
    if (estTime) {
      estTime.addEventListener('input', calculateEstimate);
    }
  }

  if (quoteOpenBtn && quoteModal) {
    quoteOpenBtn.addEventListener('click', (event) => {
      event.preventDefault();
      openQuoteModal();
    });
  }

  if (quoteCloseBtn && quoteModal) {
    quoteCloseBtn.addEventListener('click', closeQuoteModal);
    quoteModal.addEventListener('click', (event) => {
      if (event.target === quoteModal) {
        closeQuoteModal();
      }
    });
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        closeQuoteModal();
      }
    });
  }

  if (quoteForm) {
    quoteForm.addEventListener('submit', () => {
      updateQuoteModal(true);
    });
  }

  restoreEstimatorState();
  applyCurrencyUI();

  if (canEstimate) {
    // Initial Calculation
    calculateEstimate(); // Run on load
  }


  // --------------------------------------------------------------------------
  // MAGNET LEAD FORM (Audit Scan)
  // --------------------------------------------------------------------------
  window.startWebsiteAudit = (btn) => {
    const form = btn.closest('form');
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    const overlay = document.getElementById('audit-scan-overlay');
    if (!overlay) return;

    const textEl = overlay.querySelector('.scan-text');
    const radar = overlay.querySelector('.scan-radar');

    // Reset
    overlay.classList.remove('success');
    overlay.classList.add('active');
    if (radar) radar.style.display = 'block';
    if (textEl) textEl.textContent = 'Connecting...';

    // Sequence
    setTimeout(() => { if (textEl) textEl.textContent = 'Scanning URLs...'; }, 1000);
    setTimeout(() => { if (textEl) textEl.textContent = 'Checking SEO Score...'; }, 2500);
    setTimeout(() => {
      if (textEl) textEl.textContent = 'Audit Complete!';
      overlay.classList.add('success');
      if (radar) radar.style.display = 'none';
    }, 4000);

    setTimeout(() => {
      form.submit();
    }, 5000);
  };

  /* -------------------------------------------------------------------------- */
  /*                         SMART HOVER DROPDOWNS                              */
  /* -------------------------------------------------------------------------- */
  const dropdownWrappers = document.querySelectorAll('.nav-item-dropdown');
  const isDesktop = () => window.matchMedia('(min-width: 992px)').matches;

  dropdownWrappers.forEach(wrapper => {
    const menu = wrapper.querySelector('.dropdown-menu');
    const trigger = wrapper.querySelector('.js-dropdown-toggle');

    if (!menu) return;

    // 1. MOUSE ENTER (OPEN) - Desktop Only
    wrapper.addEventListener('mouseenter', () => {
      if (!isDesktop()) return;

      // Close all other instances immediately for "Smart Switch" feel
      dropdownWrappers.forEach(other => {
        if (other !== wrapper) {
          other.classList.remove('active-state');
          other.querySelector('.dropdown-menu')?.classList.remove('show');
          // Optional: handle aria-expanded if needed
        }
      });

      // Open current
      menu.classList.add('show');
      wrapper.classList.add('active-state'); // For Parent Active Color Rule
    });

    // 2. MOUSE LEAVE (CLOSE) - Desktop Only
    wrapper.addEventListener('mouseleave', () => {
      if (!isDesktop()) return;

      menu.classList.remove('show');
      wrapper.classList.remove('active-state');
    });

    // 3. CLICK EVENT (Mobile Support + Desktop Prevention)
    if (trigger) {
      trigger.addEventListener('click', (e) => {
        // Always prevent default link behavior for toggle
        e.preventDefault();

        if (!isDesktop()) {
          // Mobile: Toggle on click
          const isOpen = menu.classList.contains('show');

          // Close others
          dropdownWrappers.forEach(other => {
            other.classList.remove('active-state');
            other.querySelector('.dropdown-menu')?.classList.remove('show');
          });

          if (!isOpen) {
            menu.classList.add('show');
            wrapper.classList.add('active-state');
          }
        }
      });
    }
  });

});


