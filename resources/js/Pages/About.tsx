import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import ThemeProvider from '@/Components/ThemeProvider';
import { Head, Link } from '@inertiajs/react';

// Sections
import ScrollProgress from '@/Components/Sections/ScrollProgress';
import Tilt from 'react-parallax-tilt';
import TimelineSection from '@/Components/Sections/TimelineSection';

interface AboutProps {
    about: {
        id: number;
        title: string;
        description: string;
        image?: string;
    };
    steps: {
        id: number;
        title: string;
        description: string;
        icon?: string;
        image?: string;
    }[];
    teamMembers: {
        id: number;
        name: string;
        position: string;
        image?: string;
        social_links?: Record<string, string>;
    }[];
    partners: {
        id: number;
        name: string;
        logo: string;
    }[];
    translations: {
        banner: { title: string; description: string };
        who_we_are: string;
        process: string;
        logo_design_process: string;
        years_on_market: string;
    };
    theme?: any;
    sections_enabled?: Record<string, boolean>;
    main_services?: any[];
    social_media?: any[];
}

export default function About({
    about,
    steps = [],
    teamMembers = [],
    partners = [],
    translations,
    theme,
    sections_enabled = {},
    main_services = [],
    social_media = [],
}: AboutProps) {

    // Fallback Mock Data for Steps (In case database is empty)
    const displaySteps = steps.length > 0 ? steps : [
        { id: 1, title: 'Analiz', description: 'Brendin dərindən öyrənilməsi və strategiya.', icon: 'search' },
        { id: 2, title: 'Eskiz', description: 'Yaradıcı ideyaların vizual formaya salınması.', icon: 'pen' },
        { id: 3, title: 'Dizayn', description: 'Eskizlərin rəqəmsal və qüsursuzlaşmış variantı.', icon: 'vector-square' },
        { id: 4, title: 'Təqdimat', description: 'Hazır məhsulun müştəriyə təhvil verilməsi.', icon: 'check-circle' }
    ];

    return (
        <ThemeProvider theme={theme}>
            <MainLayout>
                <Head title={translations?.banner?.title || 'Haqqımızda'} />
                <ScrollProgress />
            
            {/* HERO SECTION - Təmiz Tailwind, Premium Background, Navbar Dəstəyi */}
            <section className="relative pt-[200px] pb-32 overflow-hidden z-10 flex items-center min-h-[50vh]">
                {/* Background Shapes for Glass Navbar to shine - (More visible in Light mode) */}
                <div className="absolute top-[-5%] left-[-5%] w-[600px] h-[600px] bg-brand-primary/40 rounded-full blur-[120px] -z-10 mix-blend-multiply pointer-events-none"></div>
                <div className="absolute bottom-[0%] right-[0%] w-[500px] h-[500px] bg-brand-secondary/40 rounded-full blur-[120px] -z-10 mix-blend-multiply pointer-events-none"></div>
                
                <div className="max-w-7xl mx-auto px-6 w-full relative z-10 text-center">
                    <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold font-display tracking-tight text-text-main mb-6 drop-shadow-sm">
                        {translations?.banner?.title || 'Haqqımızda'}
                    </h1>
                    <p className="text-lg md:text-xl text-text-sub max-w-2xl mx-auto leading-relaxed">
                        {translations?.banner?.description || 'Biz yaradıcı agentliyik.'}
                    </p>
                </div>
            </section>

            {/* WHO WE ARE / INTRO */}
            <div className="max-w-7xl mx-auto px-6 py-20 relative z-10">
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-24">
                    <div className="order-2 lg:order-1 relative">
                        {/* Premium Glass Card for Light Mode */}
                        <Tilt className="glass-card-premium" perspective={1000} scale={1.02} transitionSpeed={2000}>
                            <div className="bg-white/60 dark:bg-[#0b0f19]/50 backdrop-blur-2xl border border-white/50 dark:border-white/10 p-5 rounded-[30px] shadow-2xl relative overflow-hidden group">
                                <div className="absolute inset-0 bg-gradient-to-br from-brand-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <img 
                                    src={about?.image || '/assets/media/about/about-1.png'} 
                                    className="w-full h-auto min-h-[400px] object-cover rounded-[20px] transform group-hover:scale-105 transition-transform duration-700 shadow-inner" 
                                    alt="About Us"
                                />
                            </div>
                        </Tilt>
                    </div>
                    <div className="order-1 lg:order-2">
                        <div className="mb-4">
                            <span className="text-brand-primary font-semibold tracking-wider uppercase text-sm mb-2 block">
                                {translations?.who_we_are || 'BİZ KİMİK'}
                            </span>
                            <h2 className="text-3xl md:text-5xl font-bold font-display text-text-main mb-6 leading-tight">
                                {about?.title || 'Gələcəyi Yaradanlar'}
                            </h2>
                        </div>
                        <div 
                            className="text-text-sub text-lg leading-relaxed mb-10 prose prose-lg prose-invert"
                            dangerouslySetInnerHTML={{__html: about?.description || '<p>Chalang, brendlərin rəqəmsal dünyada parlamasına kömək edən yaradıcı agentlikdir.</p>'}}
                        />
                        
                        {/* Stats Grid */}
                        <div className="grid grid-cols-2 gap-6">
                            <div className="bg-white/60 dark:bg-white/5 backdrop-blur-xl border border-white/40 dark:border-white/5 rounded-2xl p-6 text-center transform hover:-translate-y-2 shadow-lg transition-all duration-300">
                                <h3 className="text-4xl md:text-5xl font-bold font-display text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-brand-secondary mb-2">5+</h3>
                                <p className="text-text-sub font-medium">{translations?.years_on_market || 'Bazardakı İlimiz'}</p>
                            </div>
                            <div className="bg-white/60 dark:bg-white/5 backdrop-blur-xl border border-white/40 dark:border-white/5 rounded-2xl p-6 text-center transform hover:-translate-y-2 shadow-lg transition-all duration-300">
                                <h3 className="text-4xl md:text-5xl font-bold font-display text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-brand-secondary mb-2">50+</h3>
                                <p className="text-text-sub font-medium">Uğurlu Layihə</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* PROCESS STEPS */}
                <div className="py-20">
                    <div className="text-center mb-16">
                        <span className="text-brand-primary font-semibold tracking-wider uppercase text-sm mb-2 block">
                            {translations?.process || 'PROSES'}
                        </span>
                        <h2 className="text-3xl md:text-5xl font-bold font-display text-text-main">
                            {translations?.logo_design_process || 'Dizayn Prosesimiz'}
                        </h2>
                    </div>
                    
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        {displaySteps.map((step, index) => (
                            <Tilt key={step.id || index} perspective={1000} scale={1.05} transitionSpeed={2000}>
                                <div className="bg-white/60 dark:bg-[#111827]/60 backdrop-blur-xl border border-white/40 dark:border-white/5 p-8 rounded-[30px] h-full text-center hover:border-brand-primary/50 hover:shadow-2xl transition-all duration-300 group">
                                    <div className="w-12 h-12 bg-gradient-to-br from-brand-primary to-brand-secondary text-white rounded-full flex items-center justify-center font-bold text-lg mx-auto mb-6 shadow-lg shadow-brand-primary/30 group-hover:scale-110 transition-transform">
                                        {index + 1}
                                    </div>
                                    <div className="mb-6 flex justify-center text-4xl text-brand-primary">
                                        {step.image ? (
                                            <img src={step.image} alt="Icon" className="w-16 h-16 object-contain filter group-hover:brightness-110 transition-all"/>
                                        ) : (
                                            <i className={`fas fa-${step.icon || 'star'}`}></i>
                                        )}
                                    </div>
                                    <h4 className="text-xl font-bold text-text-main mb-4">{step.title}</h4>
                                    <p className="text-text-sub text-sm leading-relaxed">
                                        {step.description?.substring(0, 100)}
                                    </p>
                                </div>
                            </Tilt>
                        ))}
                    </div>
                </div>

                {/* TIMELINE SECTION (Phase 2.7 recovery) */}
                <TimelineSection />

                {/* TEAM SECTION - Grid Update to 4 columns on large screens to fit 4 members beautifully */}
                {teamMembers.length > 0 && (
                    <div className="py-20">
                        <div className="text-center mb-16">
                            <span className="text-brand-primary font-semibold tracking-wider uppercase text-sm mb-2 block">Komandamız</span>
                            <h2 className="text-3xl md:text-5xl font-bold font-display text-text-main">Yaradıcı Beyinlər</h2>
                        </div>
                        
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            {teamMembers.map((member) => (
                                <Tilt key={member.id} perspective={1000} scale={1.02} transitionSpeed={2000}>
                                    <div className="bg-white/60 dark:bg-[#111827]/80 backdrop-blur-xl border border-white/40 dark:border-white/5 shadow-lg rounded-[30px] overflow-hidden group hover:shadow-brand-primary/20 transition-all duration-500">
                                        <div className="relative overflow-hidden aspect-[4/5]">
                                            <img 
                                                src={member.image || '/assets/media/team/team-1.png'} 
                                                className="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" 
                                                alt={member.name}
                                            />
                                            {/* Gradient Overlay for name readability */}
                                            <div className="absolute inset-0 bg-gradient-to-t from-[#0b0f19]/90 via-transparent to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            
                                            <div className="absolute bottom-0 left-0 w-full p-6 translate-y-4 group-hover:translate-y-0 transition-transform duration-300 flex justify-center gap-4 opacity-0 group-hover:opacity-100">
                                                {member.social_links && Object.entries(member.social_links).map(
                                                    ([platform, link]) => (
                                                        <a 
                                                            key={platform}
                                                            href={link} 
                                                            target="_blank"
                                                            rel="noreferrer"
                                                            className="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-brand-primary transition-colors"
                                                        >
                                                            <i className={`fab fa-${platform.toLowerCase()} text-sm`}></i>
                                                        </a>
                                                    )
                                                )}
                                            </div>
                                        </div>
                                        {/* Name and Position styling */}
                                        <div className="p-5 text-center bg-white/40 dark:bg-transparent border-t border-white/20 dark:border-white/5 backdrop-blur-md">
                                            <h4 className="text-xl font-bold text-text-main mb-1">{member.name}</h4>
                                            <span className="text-brand-secondary font-medium text-sm tracking-wide">
                                                {member.position}
                                            </span>
                                        </div>
                                    </div>
                                </Tilt>
                            ))}
                        </div>
                    </div>
                )}

                {/* JOIN THE FORCE CTA */}
                <div className="py-20">
                    <div className="bg-gradient-to-r from-brand-primary/10 to-brand-secondary/10 dark:from-brand-primary/20 dark:to-brand-secondary/20 backdrop-blur-2xl border border-brand-primary/20 rounded-[40px] p-12 md:p-16 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden shadow-2xl">
                        <div className="absolute -top-20 -right-20 w-80 h-80 bg-brand-primary/30 rounded-full blur-[80px]"></div>
                        <div className="absolute -bottom-20 -left-20 w-80 h-80 bg-brand-secondary/30 rounded-full blur-[80px]"></div>
                        
                        <div className="relative z-10 text-center md:text-left w-full md:w-2/3">
                            <span className="text-brand-primary font-semibold tracking-wider uppercase text-sm mb-3 block">Join the Force</span>
                            <h3 className="text-4xl md:text-5xl font-bold font-display text-text-main mb-4">Komandaya qoşul</h3>
                            <p className="text-text-sub text-lg max-w-xl">Biz həmişə istedad axtarırıq. Kreativsənsə, CV göndər və birlikdə möcüzələr yaradaq.</p>
                        </div>
                        <div className="relative z-10 w-full md:w-1/3 flex justify-center md:justify-end mt-6 md:mt-0">
                            <Link 
                                href="/contact" 
                                className="inline-flex items-center justify-center px-10 py-5 bg-brand-primary text-white font-bold rounded-full hover:bg-brand-secondary hover:shadow-[0_0_30px_rgba(213,0,249,0.4)] hover:scale-105 transition-all duration-300 text-lg w-full md:w-auto whitespace-nowrap magnet-btn"
                            >
                                CV göndər
                                <svg className="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </Link>
                        </div>
                    </div>
                </div>

                {/* PARTNERS */}
                {partners.length > 0 && (
                    <div className="py-20 border-t border-black/5 dark:border-white/5 mt-10">
                        <div className="text-center mb-12">
                            <h4 className="text-sm font-bold tracking-widest uppercase text-brand-secondary">Bizə Güvənənlər</h4>
                        </div>
                        <div className="flex flex-wrap justify-center items-center gap-12 md:gap-24 opacity-60">
                            {partners.map((partner) => (
                                <div key={partner.id} className="group transition-all duration-300 hover:opacity-100 hover:scale-110">
                                    <img 
                                        src={partner.logo} 
                                        alt={partner.name} 
                                        className="h-12 w-auto object-contain filter grayscale group-hover:grayscale-0 transition-all duration-500 drop-shadow-sm"
                                    />
                                </div>
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </MainLayout>
        </ThemeProvider>
    );
}