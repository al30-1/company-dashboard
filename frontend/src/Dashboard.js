// frontend/src/Dashboard.js
import React, { useState, useEffect } from 'react';
import axios from 'axios';

function Dashboard() {
  const [modules, setModules] = useState([]);
  const [search, setSearch] = useState('');
  const [user, setUser] = useState(null);
  const [company, setCompany] = useState(null);

  useEffect(() => {
    const token = localStorage.getItem('token');
    const userData = localStorage.getItem('user');
    const companyData = localStorage.getItem('company');

    if (!token) {
      window.location.href = '/login';
      return;
    }

    if (userData) {
      setUser(JSON.parse(userData));
    }

    if (companyData) {
      const parsedCompany = JSON.parse(companyData);
      setCompany(parsedCompany);
      // Apply theme based on the company stored in localStorage when Dashboard mounts
      document.documentElement.style.setProperty('--primary', parsedCompany.primary_color);
      if (parsedCompany.accent_color) {
        document.documentElement.style.setProperty('--accent', parsedCompany.accent_color);
      } else {
        // Clear accent color if not provided
        document.documentElement.style.setProperty('--accent', '');
      }
    }

    const fetchModules = async () => {
      try {
        const res = await axios.get('http://localhost:8000/api/modules', {
          headers: { Authorization: `Bearer ${token}` },
        });
        console.log('Modules loaded:', res.data);
        setModules(res.data);
      } catch (err) {
        console.error('Failed to load modules:', err);
        if (err.response?.status === 401) {
          localStorage.clear();
          window.location.href = '/login';
        }
      }
    };
    fetchModules();
  }, []);

  const handleLogout = async () => {
    const token = localStorage.getItem('token');
    try {
      await axios.post('http://localhost:8000/api/logout', {}, {
        headers: { Authorization: `Bearer ${token}` }
      });
    } catch (err) {
      console.error('Logout error:', err);
    }
    localStorage.clear();
    // Clear theme variables on logout
    document.documentElement.style.setProperty('--primary', '');
    document.documentElement.style.setProperty('--accent', '');
    window.location.href = '/login';
  };

  const filterTree = (tree, q) => {
    if (!q) return tree;
    const ql = q.toLowerCase();
    return tree
      .map((sys) => {
        const modules = sys.modules
          .map((mod) => {
            const subs = mod.submodules.filter((s) =>
              s.name.toLowerCase().includes(ql)
            );
            return { ...mod, submodules: subs };
          })
          .filter(
            (m) =>
              m.submodules.length ||
              m.module_name.toLowerCase().includes(ql)
          );
        return { ...sys, modules };
      })
      .filter(
        (s) =>
          s.modules.length || s.system_name.toLowerCase().includes(ql)
      );
  };

  const filtered = filterTree(modules, search);

  return (
    <div style={{ 
      display: 'flex', 
      height: '100vh', 
      flexDirection: 'column',
      fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif'
    }}>
      {/* Header */}
      <div style={{ 
        background: `linear-gradient(135deg, var(--primary) 0%, ${company?.accent_color || 'var(--primary)'} 100%)`,
        color: 'white',
        padding: '20px 32px',
        boxShadow: '0 4px 12px rgba(0, 0, 0, 0.15)',
        display: 'flex',
        justifyContent: 'space-between',
        alignItems: 'center',
        zIndex: 10
      }}>
        <div>
          <h1 style={{ 
            margin: 0, 
            fontSize: '24px', 
            fontWeight: '700',
            letterSpacing: '-0.5px'
          }}>
            {company?.name || 'Dashboard'}
          </h1>
          <p style={{ 
            margin: '4px 0 0 0', 
            fontSize: '14px', 
            opacity: 0.9,
            fontWeight: '400'
          }}>
            Welcome back, {user?.full_name || user?.username}
          </p>
        </div>
        <button 
          onClick={handleLogout}
          style={{
            padding: '10px 24px',
            backgroundColor: 'rgba(255, 255, 255, 0.2)',
            color: 'white',
            border: '2px solid rgba(255, 255, 255, 0.3)',
            borderRadius: '8px',
            cursor: 'pointer',
            fontSize: '14px',
            fontWeight: '600',
            transition: 'all 0.3s',
            backdropFilter: 'blur(10px)'
          }}
          onMouseOver={(e) => {
            e.target.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
            e.target.style.borderColor = 'rgba(255, 255, 255, 0.5)';
            e.target.style.transform = 'translateY(-2px)';
          }}
          onMouseOut={(e) => {
            e.target.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
            e.target.style.borderColor = 'rgba(255, 255, 255, 0.3)';
            e.target.style.transform = 'translateY(0)';
          }}
        >
          Logout
        </button>
      </div>

      {/* Main content */}
      <div style={{ display: 'flex', flex: 1, overflow: 'hidden' }}>
        {/* Left Sidebar */}
        <div
          style={{
            width: '280px',
            backgroundColor: '#ffffff',
            borderRight: '1px solid #e5e7eb',
            display: 'flex',
            flexDirection: 'column',
            boxShadow: '2px 0 8px rgba(0, 0, 0, 0.05)'
          }}
        >
          {/* Search Box */}
          <div style={{ padding: '20px 16px' }}>
            <div style={{ position: 'relative' }}>
              <input
                type="text"
                placeholder="Search modules..."
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                style={{ 
                  width: '100%', 
                  padding: '12px 16px 12px 40px',
                  fontSize: '14px',
                  border: '2px solid #e5e7eb',
                  borderRadius: '10px',
                  outline: 'none',
                  transition: 'all 0.2s',
                  boxSizing: 'border-box',
                  backgroundColor: '#f9fafb'
                }}
                onFocus={(e) => {
                  e.target.style.borderColor = 'var(--primary)';
                  e.target.style.backgroundColor = '#ffffff';
                }}
                onBlur={(e) => {
                  e.target.style.borderColor = '#e5e7eb';
                  e.target.style.backgroundColor = '#f9fafb';
                }}
              />
              <svg 
                style={{ 
                  position: 'absolute', 
                  left: '12px', 
                  top: '50%', 
                  transform: 'translateY(-50%)',
                  width: '18px',
                  height: '18px',
                  opacity: 0.4
                }}
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
              >
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
          </div>

          {/* Modules List */}
          <div style={{ 
            flex: 1, 
            overflowY: 'auto',
            padding: '0 16px 20px 16px'
          }}>
            {filtered.length === 0 ? (
              <div style={{ 
                padding: '40px 20px', 
                textAlign: 'center',
                color: '#9ca3af',
                fontSize: '14px'
              }}>
                {modules.length === 0 ? (
                  <div>
                    <div style={{ fontSize: '32px', marginBottom: '12px' }}>📦</div>
                    <div>Loading modules...</div>
                  </div>
                ) : (
                  <div>
                    <div style={{ fontSize: '32px', marginBottom: '12px' }}>🔍</div>
                    <div>No modules found</div>
                  </div>
                )}
              </div>
            ) : (
              filtered.map((system, sysIdx) => (
                <div 
                  key={system.system_id} 
                  style={{ 
                    marginBottom: sysIdx < filtered.length - 1 ? '24px' : '0'
                  }}
                >
                  {/* System Name */}
                  <div style={{ 
                    fontWeight: '700', 
                    fontSize: '13px',
                    color: '#6b7280',
                    textTransform: 'uppercase',
                    letterSpacing: '0.5px',
                    marginBottom: '12px',
                    padding: '0 4px'
                  }}>
                    {system.system_name}
                  </div>

                  {/* Modules */}
                  {system.modules.map((module) => (
                    <div key={module.module_id} style={{ marginBottom: '16px' }}>
                      <div style={{ 
                        fontWeight: '600', 
                        fontSize: '14px',
                        color: '#374151',
                        marginBottom: '8px',
                        padding: '0 4px'
                      }}>
                        {module.module_name}
                      </div>

                      {/* Submodules */}
                      {module.submodules.map((sub) => (
                        <div
                          key={sub.id}
                          style={{
                            padding: '10px 12px',
                            cursor: 'pointer',
                            color: '#6b7280',
                            fontSize: '13px',
                            borderRadius: '8px',
                            marginBottom: '4px',
                            transition: 'all 0.2s',
                            display: 'flex',
                            alignItems: 'center',
                            gap: '8px'
                          }}
                          onClick={() => alert(`Navigate to: ${sub.route || sub.name}`)}
                          onMouseOver={(e) => {
                            e.currentTarget.style.backgroundColor = 'var(--primary)';
                            e.currentTarget.style.color = 'white';
                            e.currentTarget.style.transform = 'translateX(4px)';
                          }}
                          onMouseOut={(e) => {
                            e.currentTarget.style.backgroundColor = 'transparent';
                            e.currentTarget.style.color = '#6b7280';
                            e.currentTarget.style.transform = 'translateX(0)';
                          }}
                        >
                          <svg style={{ width: '16px', height: '16px', flexShrink: 0 }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                          </svg>
                          <span>{sub.name}</span>
                        </div>
                      ))}
                    </div>
                  ))}
                </div>
              ))
            )}
          </div>
        </div>

        {/* Right Content Area */}
        <div style={{ 
          flex: 1, 
          padding: '32px',
          backgroundColor: '#f9fafb',
          overflowY: 'auto'
        }}>
          {/* Welcome Card */}
          <div style={{
            backgroundColor: 'white',
            borderRadius: '12px',
            padding: '32px',
            marginBottom: '24px',
            boxShadow: '0 1px 3px rgba(0, 0, 0, 0.1)',
            border: '1px solid #e5e7eb'
          }}>
            <h2 style={{ 
              margin: '0 0 12px 0', 
              fontSize: '28px',
              fontWeight: '700',
              color: '#111827'
            }}>
              Welcome to Your Dashboard
            </h2>
            <p style={{ 
              margin: 0, 
              fontSize: '16px',
              color: '#6b7280',
              lineHeight: '1.6'
            }}>
              Select a module from the sidebar to get started. All your permitted features are accessible from the navigation menu.
            </p>
          </div>

          {/* Stats Cards */}
          <div style={{
            display: 'grid',
            gridTemplateColumns: 'repeat(auto-fit, minmax(240px, 1fr))',
            gap: '20px',
            marginBottom: '24px'
          }}>
            <div style={{
              backgroundColor: 'white',
              borderRadius: '12px',
              padding: '24px',
              boxShadow: '0 1px 3px rgba(0, 0, 0, 0.1)',
              border: '1px solid #e5e7eb',
              borderLeft: `4px solid var(--primary)`
            }}>
              <div style={{ fontSize: '14px', color: '#6b7280', marginBottom: '8px', fontWeight: '600' }}>
                Total Systems
              </div>
              <div style={{ fontSize: '32px', fontWeight: '700', color: '#111827' }}>
                {modules.length}
              </div>
            </div>

            <div style={{
              backgroundColor: 'white',
              borderRadius: '12px',
              padding: '24px',
              boxShadow: '0 1px 3px rgba(0, 0, 0, 0.1)',
              border: '1px solid #e5e7eb',
              borderLeft: `4px solid var(--accent)`
            }}>
              <div style={{ fontSize: '14px', color: '#6b7280', marginBottom: '8px', fontWeight: '600' }}>
                Available Modules
              </div>
              <div style={{ fontSize: '32px', fontWeight: '700', color: '#111827' }}>
                {modules.reduce((acc, sys) => acc + sys.modules.length, 0)}
              </div>
            </div>

            <div style={{
              backgroundColor: 'white',
              borderRadius: '12px',
              padding: '24px',
              boxShadow: '0 1px 3px rgba(0, 0, 0, 0.1)',
              border: '1px solid #e5e7eb',
              borderLeft: '4px solid #10b981'
            }}>
              <div style={{ fontSize: '14px', color: '#6b7280', marginBottom: '8px', fontWeight: '600' }}>
                Your Company
              </div>
              <div style={{ fontSize: '20px', fontWeight: '700', color: '#111827' }}>
                {company?.name || 'N/A'}
              </div>
            </div>
          </div>

          {/* Info Box */}
          <div style={{
            backgroundColor: 'white',
            borderRadius: '12px',
            padding: '24px',
            boxShadow: '0 1px 3px rgba(0, 0, 0, 0.1)',
            border: '1px solid #e5e7eb'
          }}>
            <h3 style={{ 
              margin: '0 0 12px 0', 
              fontSize: '18px',
              fontWeight: '600',
              color: '#111827'
            }}>
              Quick Tips
            </h3>
            <ul style={{
              margin: 0,
              paddingLeft: '20px',
              color: '#6b7280',
              lineHeight: '1.8',
              fontSize: '14px'
            }}>
              <li>Use the search box to quickly find modules</li>
              <li>Click on any submodule to navigate to that section</li>
              <li>Your permissions are pre-filtered for security</li>
              <li>The header color matches your company theme</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Dashboard;
