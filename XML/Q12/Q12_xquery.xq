for $book in doc("Q12.xml")/bib/book
order by xs:decimal(normalize-space($book/price))
return
    <title>{ data($book/title) }</title>


let $count := count(doc("Q12.xml")/bib/book[author = "Abiteboul"])
return
    <result>
        <author>Abiteboul</author>
        <book-count>{ $count }</book-count>
    </result>


let $authors := distinct-values(doc("Q12.xml")/bib/book/author)
for $author in $authors
let $books := doc("Q12.xml")/bib/book[author = $author]
return
    <author>
        <name>{ $author }</name>
        <book-count>{ count($books) }</book-count>
    </author>
