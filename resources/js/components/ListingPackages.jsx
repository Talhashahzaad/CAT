import React, { useState, useEffect } from 'react';
import axios from 'axios';

const ListingPackages = () => {
    const [packages, setPackages] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchPackages = async () => {
            try {
                const response = await axios.get('/api/listing-packages');
                setPackages(response.data);
                setLoading(false);
            } catch (err) {
                setError('Error loading packages. Please try again later.');
                setLoading(false);
            }
        };

        fetchPackages();
    }, []);

    const formatCurrency = (amount, type) => {
        if (type === 'free') return 'Free';
        
        // Get currency settings from your config
        const currencyIcon = window.siteCurrencyIcon || '₹';
        const currencyPosition = window.siteCurrencyPosition || 'left';
        
        return currencyPosition === 'left' 
            ? `${currencyIcon}${amount}`
            : `${amount}${currencyIcon}`;
    };

    if (loading) {
        return (
            <div className="container py-5">
                <div className="row">
                    <div className="col-12 text-center">
                        <div className="spinner-border text-primary" role="status">
                            <span className="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="container py-5">
                <div className="row">
                    <div className="col-12 text-center">
                        <div className="alert alert-danger">{error}</div>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className="container py-5">
            <div className="row">
                <div className="col-12">
                    <h2 className="text-center mb-5">Choose Your Listing Package</h2>
                </div>
            </div>

            <div className="row">
                {packages.map((pkg) => (
                    <div key={pkg.id} className="col-md-4 mb-4">
                        <div className="card h-100">
                            <div className="card-header text-center">
                                <h3 className="card-title">{pkg.name}</h3>
                                <div className="price">
                                    {formatCurrency(pkg.price, pkg.type)}
                                </div>
                                <div className="duration">{pkg.number_of_days} Days</div>
                            </div>
                            <div className="card-body">
                                <ul className="list-unstyled">
                                    <li>
                                        <i className="fas fa-check text-success"></i> {pkg.num_of_listing} Listings
                                    </li>
                                    <li>
                                        <i className="fas fa-check text-success"></i> {pkg.cat_ecommarce ? 'E-commerce Features' : 'No E-commerce'}
                                    </li>
                                    <li>
                                        <i className="fas fa-check text-success"></i> {pkg.cat_pro_social_media ? 'Professional Social Media' : 'Basic Social Media'}
                                    </li>
                                    <li>
                                        <i className="fas fa-check text-success"></i> {pkg.social_media_post ? 'Social Media Posts' : 'No Social Media Posts'}
                                    </li>
                                    <li>
                                        <i className="fas fa-check text-success"></i> {pkg.featured_listing ? 'Featured Listings' : 'No Featured Listings'}
                                    </li>
                                    <li>
                                        <i className="fas fa-check text-success"></i> {pkg.multiple_locations ? 'Multiple Locations' : 'Single Location'}
                                    </li>
                                    <li>
                                        <i className="fas fa-check text-success"></i> {pkg.live_chat ? 'Live Chat Support' : 'No Live Chat'}
                                    </li>
                                </ul>
                            </div>
                            <div className="card-footer text-center">
                                <a href={`/checkout/${pkg.id}`} className="btn btn-primary">
                                    Select Package
                                </a>
                            </div>
                        </div>
                    </div>
                ))}
            </div>

            <style jsx>{`
                .card {
                    transition: transform 0.3s ease;
                    border: none;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                .card:hover {
                    transform: translateY(-5px);
                }

                .card-header {
                    background: #f8f9fa;
                    border-bottom: none;
                    padding: 2rem 1rem;
                }

                .card-title {
                    color: #333;
                    font-weight: 600;
                    margin-bottom: 1rem;
                }

                .price {
                    font-size: 2rem;
                    font-weight: 700;
                    color: #007bff;
                    margin-bottom: 0.5rem;
                }

                .duration {
                    color: #6c757d;
                    font-size: 1.1rem;
                }

                .card-body {
                    padding: 2rem 1rem;
                }

                .card-body li {
                    margin-bottom: 0.75rem;
                    color: #555;
                }

                .card-footer {
                    background: #f8f9fa;
                    border-top: none;
                    padding: 1.5rem 1rem;
                }

                .btn-primary {
                    padding: 0.75rem 2rem;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
            `}</style>
        </div>
    );
};

export default ListingPackages; 