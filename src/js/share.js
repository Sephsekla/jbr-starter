export default function initMapShare() {

  const printStyles = `
<style>
*{font-family: sans-serif;}
	ul{list-style: none;}
	p.map{display: none;}
	h5{font-size: 1.2rem; margin-bottom: 0;}
</style>
`;

  $('#print-list a').on('click', function (e) {
    e.preventDefault();
    // console.log($(this).attr('href'));
    //
    // const w = window.open();
    // w.document.write(printStyles);
    // w.document.write(`<ul>${$($(this).attr('href')).html()}</ul>`);
    // w.print();
    // w.close();

    window.print();
  });

  $('#email-list a').on('click', function (e) {
    e.preventDefault();

    var share_url = window.location.origin + window.location.pathname + '?st='+$('select#state').val()+'&pn='+$('select#pharmacy_name').val();

    //window.location.href = `mailto:?subject=Ferring%20Fertility%20Pharmacies&body=${share_url}`;
    window.open(`mailto:?subject=Ferring%20Fertility%20Pharmacies&body=${share_url}`)
  });

}
