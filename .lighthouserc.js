module.exports = {
  ci: {
    collect: {
      settings: {chromeFlags: '--no-sandbox'},
    },
    upload: {
      target: 'temporary-public-storage',
    },
  },
};
