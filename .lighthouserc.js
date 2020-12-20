module.exports = {
  ci: {
    collect: {
      url: ['https://taskord.com'],
      settings: {chromeFlags: '--no-sandbox'},
    },
    upload: {
      target: 'temporary-public-storage',
    },
  },
};
