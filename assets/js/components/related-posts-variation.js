/**
 * Related Posts Query Loop Block Variation
 *
 * @package SwiftPressFSE
 * @author Dapo Obembe <https://www.dapoobembe.com>
 */

(function () {
  const { registerBlockVariation } = wp.blocks;
  const { __ } = wp.i18n;
  const { addFilter } = wp.hooks;
  const { createHigherOrderComponent } = wp.compose;
  const { Fragment, createElement } = wp.element;
  const { InspectorControls } = wp.blockEditor;
  const { PanelBody, SelectControl, ToggleControl } = wp.components;

  // Register the Related Posts variation.
  registerBlockVariation("core/query", {
    name: "related-posts",
    title: __("Related Posts", "swiftpress"),
    description: __(
      "Display posts related to the current post by category or tags.",
      "swiftpress"
    ),
    icon: "networking",
    attributes: {
      namespace: "swiftpress/related-posts",
      query: {
        perPage: 3,
        pages: 0,
        offset: 0,
        postType: "post",
        order: "desc",
        orderBy: "date",
        author: "",
        search: "",
        exclude: [],
        sticky: "",
        inherit: false,
        relatedPosts: true,
        relatedPostsBy: "category_or_tag",
      },
    },
    scope: ["inserter"],
    isActive: (blockAttributes) => {
      return blockAttributes.namespace === "swiftpress/related-posts";
    },
    innerBlocks: [
      [
        "core/post-template",
        {
          layout: {
            type: "grid",
            columnCount: 3,
          },
        },
        [
          [
            "core/post-featured-image",
            {
              isLink: true,
              aspectRatio: "16/9",
            },
          ],
          [
            "core/post-title",
            {
              isLink: true,
              level: 3,
            },
          ],
          [
            "core/post-excerpt",
            {
              showMoreOnNewLine: false,
              excerptLength: 20,
            },
          ],
        ],
      ],
    ],
  });

  // Add custom controls to the Query block when it's our variation
  const withRelatedPostsControls = createHigherOrderComponent((BlockEdit) => {
    return function (props) {
      const { attributes, setAttributes, name } = props;

      // Only add controls to Query blocks with our variation
      if (
        name !== "core/query" ||
        attributes.namespace !== "swiftpress/related-posts"
      ) {
        return createElement(BlockEdit, props);
      }

      const { query = {} } = attributes;

      return createElement(
        Fragment,
        null,
        createElement(BlockEdit, props),
        createElement(
          InspectorControls,
          null,
          createElement(
            PanelBody,
            {
              title: __("Related Posts Settings", "swiftpress"),
              initialOpen: true,
            },
            createElement(ToggleControl, {
              label: __("Enable Related Posts", "swiftpress"),
              checked: query.relatedPosts || false,
              onChange: function (value) {
                setAttributes({
                  query: Object.assign({}, query, { relatedPosts: value }),
                });
              },
              help: __("Show posts related to the current post", "swiftpress"),
            }),
            query.relatedPosts
              ? createElement(SelectControl, {
                  label: __("Related By", "swiftpress"),
                  value: query.relatedPostsBy || "category_or_tag",
                  options: [
                    {
                      label: __("Category (with tag fallback)", "swiftpress"),
                      value: "category_or_tag",
                    },
                    {
                      label: __("Category Only", "swiftpress"),
                      value: "category",
                    },
                    {
                      label: __("Tags Only", "swiftpress"),
                      value: "tag",
                    },
                  ],
                  onChange: function (value) {
                    setAttributes({
                      query: Object.assign({}, query, {
                        relatedPostsBy: value,
                      }),
                    });
                  },
                  help: __(
                    "Choose how to determine related posts",
                    "swiftpress"
                  ),
                })
              : null
          )
        )
      );
    };
  }, "withRelatedPostsControls");

  addFilter(
    "editor.BlockEdit",
    "swiftpress/related-posts-controls",
    withRelatedPostsControls
  );
})();
