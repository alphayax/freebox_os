import { TestAngular2Page } from './app.po';

describe('test-angular2 App', function() {
  let page: TestAngular2Page;

  beforeEach(() => {
    page = new TestAngular2Page();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
