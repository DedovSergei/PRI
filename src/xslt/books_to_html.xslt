<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <!-- Transform the books XML into an HTML table -->
    <xsl:output method="html" encoding="UTF-8" indent="yes"/>

    <xsl:template match="/books">
        <table class="book-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                    <th>Genre</th>
                    <th>Summary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <xsl:apply-templates select="book"/>
            </tbody>
        </table>
    </xsl:template>

    <xsl:template match="book">
        <tr>
            <td><xsl:value-of select="@id"/></td>
            <td><xsl:value-of select="title"/></td>
            <td><xsl:value-of select="author"/></td>
            <td><xsl:value-of select="publicationYear"/></td>
            <td><xsl:value-of select="genre"/></td>
            <td><xsl:value-of select="summary"/></td>
            <td>
                <a>
                    <xsl:attribute name="href">
                        <xsl:text>edit.php?id=</xsl:text>
                        <xsl:value-of select="@id"/>
                    </xsl:attribute>
                    Edit
                </a>
            </td>
        </tr>
    </xsl:template>
</xsl:stylesheet>
