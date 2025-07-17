import React, { useEffect } from 'react';

export default function ApiCollection() {
  useEffect(() => {
    const script = document.createElement('script');
    script.src = 'https://cdn.redoc.ly/redoc/latest/bundles/redoc.standalone.js';
    script.onload = () => {
      window.Redoc.init('/AI Logs.postman_collection.json', {}, document.getElementById('redoc-container'));
    };
    document.body.appendChild(script);
  }, []);

  return (
    <div>
      <h1>API Reference</h1>
      <div id="redoc-container" />
    </div>
  );
}
