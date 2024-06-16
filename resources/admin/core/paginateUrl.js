export default function paginateUrl(page, query) {
    if (page !== parseInt(query.page)) {
        this.$router.push({
            query: {
                page: page
            }
        });
        if(page === 1) {
            this.$router.push({ query: {} });
        }

        return page;
    }
}
