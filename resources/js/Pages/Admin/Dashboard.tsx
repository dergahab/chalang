import { usePage } from '@inertiajs/react';
import Card from '@/Components/ui/Card';
import Button from '@/Components/ui/Button';

interface Stats {
    services: number;
    portfolios: number;
    blogs: number;
    messages: number;
    case_studies: number;
    testimonials: number;
    partners: number;
    team_members: number;
    users: number;
    roles: number;
}

interface Message {
    id: number;
    name: string;
    email: string;
    subject: string;
    created_at: string;
}

interface Blog {
    id: number;
    title: string;
    slug: string;
    created_at: string;
}

interface Props {
    [key: string]: unknown;
    stats: Stats;
    latestMessages: Message[];
    latestBlogs: Blog[];
}

export default function Dashboard() {
    const { props } = usePage<Props>();
    const { stats, latestMessages, latestBlogs } = props;

    const statCards = [
        { label: 'Services', value: stats.services, color: 'blue' },
        { label: 'Portfolios', value: stats.portfolios, color: 'purple' },
        { label: 'Blogs', value: stats.blogs, color: 'green' },
        { label: 'Messages', value: stats.messages, color: 'orange' },
        { label: 'Case Studies', value: stats.case_studies, color: 'pink' },
        { label: 'Testimonials', value: stats.testimonials, color: 'yellow' },
    ];

    return (
        <div className="p-6">
            <h1 className="text-2xl font-bold mb-6">Admin Dashboard</h1>

            {/* Stats Grid */}
            <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                {statCards.map((card, index) => (
                    <Card key={index} className="p-4">
                        <p className="text-sm text-gray-500">{card.label}</p>
                        <p className="text-2xl font-bold">{card.value}</p>
                    </Card>
                ))}
            </div>

            {/* Recent Activity */}
            <div className="grid md:grid-cols-2 gap-6">
                {/* Latest Messages */}
                <Card className="p-4">
                    <h2 className="text-lg font-semibold mb-4">Latest Messages</h2>
                    {latestMessages.length > 0 ? (
                        <ul className="space-y-3">
                            {latestMessages.map((msg) => (
                                <li key={msg.id} className="border-b pb-2">
                                    <p className="font-medium">{msg.name}</p>
                                    <p className="text-sm text-gray-600">{msg.subject}</p>
                                    <p className="text-xs text-gray-400">{msg.email}</p>
                                </li>
                            ))}
                        </ul>
                    ) : (
                        <p className="text-gray-500">No messages yet</p>
                    )}
                </Card>

                {/* Latest Blogs */}
                <Card className="p-4">
                    <h2 className="text-lg font-semibold mb-4">Latest Blogs</h2>
                    {latestBlogs.length > 0 ? (
                        <ul className="space-y-3">
                            {latestBlogs.map((blog) => (
                                <li key={blog.id} className="border-b pb-2">
                                    <p className="font-medium">{blog.title}</p>
                                    <p className="text-xs text-gray-400">{blog.slug}</p>
                                </li>
                            ))}
                        </ul>
                    ) : (
                        <p className="text-gray-500">No blogs yet</p>
                    )}
                </Card>
            </div>

            {/* Test Button */}
            <div className="mt-6">
                <Button variant="primary">Test Button</Button>
            </div>
        </div>
    );
}
